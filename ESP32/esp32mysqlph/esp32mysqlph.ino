#include <WiFi.h>             // wifi庫
#include <NTPClient.h>        //時間庫
#include <MySQL_Connection.h>    // Arduino連接Mysql的庫
#include <MySQL_Cursor.h>
#include <EEPROM.h>
//PH庫
#include <DFRobot_ESP_PH.h>
//溫度庫
#include <OneWire.h>
#include <DallasTemperature.h>

// 儲存日期及時間的變數
String formattedDate;
String dayStamp;
String timeStamp;
//時間用
WiFiUDP ntpUDP;
NTPClient timeClient(ntpUDP);

//溫度
#define oneWireBus 12  //溫度gpio_pin
OneWire oneWire(oneWireBus);
DallasTemperature temp(&oneWire);

//PH
DFRobot_ESP_PH ph;
#define ESPADC 4096.0   //the esp Analog Digital Convertion value
#define ESPVOLTAGE 3300 //the esp voltage supply value
#define PH_PIN 35    //the esp gpio data pin number
float voltage, phValue, temperature;

//水位
#define waterSensor 13
int waterVal;

IPAddress server_addr(140,127,32,14);   // 安裝Mysql的電腦的IP地址
char user[] = "yourmysql account";              // Mysql的用戶名
char password[] = "yourpassword";        // 登陸Mysql的密碼

// Mysql中添加一條數據的命令
// arduino_test，test1：剛纔創建的數據和表
char INSERT_SQL[] = "INSERT INTO  fishai.sensor(dayStamp,timeStamp,jarid,waterlavel,temperature,PH) VALUES ('%s','%s','%d','%s','%f','%f')";

char ssid[] = "yourssid";     // your network SSID (name)
char pass[] = "yourpassword";  // your network password

WiFiClient client;                 // 聲明一個Mysql客戶端，在lianjieMysql中使用
MySQL_Connection conn(&client);
MySQL_Cursor* cursor;    // 

String appenddata(){
  //取得日期
   while(!timeClient.update()) {
    timeClient.forceUpdate();
    }
    
  formattedDate = timeClient.getFormattedDate();
  int splitT = formattedDate.indexOf("T");
  dayStamp = formattedDate.substring(0, splitT);

  //取得時間
  timeStamp = formattedDate.substring(splitT+1, formattedDate.length()-1);
   return dayStamp,timeStamp;
  }

void printWifiData() {
  // print your WiFi shield's IP address:
  IPAddress ip = WiFi.localIP();
  Serial.print("IP Address: ");
  Serial.println(ip);
  Serial.println(ip);

  // print your MAC address:
  byte mac[6];
  WiFi.macAddress(mac);
  Serial.print("MAC address: ");
  Serial.print(mac[5], HEX);
  Serial.print(":");
  Serial.print(mac[4], HEX);
  Serial.print(":");
  Serial.print(mac[3], HEX);
  Serial.print(":");
  Serial.print(mac[2], HEX);
  Serial.print(":");
  Serial.print(mac[1], HEX);
  Serial.print(":");
  Serial.println(mac[0], HEX);
}

//溫度感測器
float readTemperature(){
  temp.requestTemperatures(); 
  float temperatureC = temp.getTempCByIndex(0);
  //float temperatureF = temp.getTempFByIndex(0);
  Serial.print(temperatureC);
  Serial.println("ºC");
  //Serial.print(temperatureF);
  //Serial.println("ºF");
     return temperatureC;
  }

//PH感測器
float readPH(){
static unsigned long timepoint = millis();
  if (millis() - timepoint > 1000U) //time interval: 1s
  {
    timepoint = millis();
    voltage = analogRead(PH_PIN) / ESPADC * ESPVOLTAGE; // read the voltage
    Serial.print("voltage:");
    Serial.println(voltage, 4);
    temperature = readTemperature();  // read your temperature sensor to execute temperature compensation
    phValue = ph.readPH(voltage, temperature); // convert voltage to pH with temperature compensation
    Serial.print("pH:");
    Serial.println(phValue, 4);
  }
  ph.calibration(voltage, temperature); // calibration process by Serail CMD
    return phValue;
  }
//水位
String watersensor(){
  // put your main code here, to run repeatedly:
  String waterlevel;
  waterVal = analogRead(waterSensor); //read the water sensor
  Serial.print("Pin Value   ");
  Serial.println(waterVal);
  if(waterVal >=1900){
    waterlevel = "high";
    Serial.println(waterlevel);
  }
  else if((waterVal <1900) && (waterVal >=1000))
  {
    waterlevel = "appropriate";
    Serial.println(waterlevel);
    }
  else if((waterVal <800) &&(waterVal >0))
  {
    waterlevel = "low";
    Serial.println(waterlevel);
    }
  else if(waterVal ==0)
  {
    waterlevel = "danger";
    Serial.println(waterlevel);
    }
  delay(200);
  return waterlevel;
}

double randomDouble(double minf, double maxf)
{
  return minf + random(1UL << 31) * (maxf - minf) / (1UL << 31);  // use 1ULL<<63 for max double values)
}

// 讀取傳感器的數據並寫入到數據庫
void readAndRecordData(){
  char buff[2048]; // 定義存儲傳感器數據的數組
  dayStamp,timeStamp = appenddata();
  int jarid=1;     
  String waterlavel=watersensor();
  float temperature=readTemperature();
  floatreadPH()readPH()readPH()readPH()readPH()readPH()readPH()readPH()readPH()readPH()readPH()readPH()readPH()readPH()readPH()readPH()readPH()readPH()
  
   Serial.println("start");
   Serial.println("日期:"+dayStamp);
   Serial.println("時間:"+timeStamp);
   Serial.println("魚缸編號:"+String(jarid));
   Serial.println("水位狀態:"+waterlavel);
   Serial.println("temperature:"+String(temperature));             // 在串口中打印讀取到的溫度
   Serial.println("PH:"+String(PH));        // 在串口中打印讀取到的PH
        
   // 將傳感器採集的浮點數轉換爲3位整數一位小數的字串放入temp
   //dtostrf(dht.readHumidity(),3,1,tem);
   //dtostrf(dht.readTemperature(),2,1,hem);
   sprintf(buff,INSERT_SQL,dayStamp,timeStamp,jarid,waterlavel,temperature,PH);                 // 講tem和hem中數據放入SQL中
   MySQL_Cursor *cur_mem = new MySQL_Cursor(&conn);         // 創建一個Mysql實例
   cur_mem->execute(buff);         // 將採集到的溫溼度值插入數據庫中
   Serial.println("讀取傳感器數據，並寫入數據庫");
   delete cur_mem;        // 刪除mysql實例爲下次採集作準備
}

void setup()
{
  Serial.begin(115200);
  
  WiFi.begin(ssid, pass);
  
  while (WiFi.status() != WL_CONNECTED) {
    delay(1500);
    Serial.println("Connecting to WiFi.. SSID:");
    Serial.println(ssid);
  }

  Serial.println("Connected to the WiFi network SSID:");
  Serial.println(ssid);
  printWifiData();
  timeClient.begin();//時間
  timeClient.setTimeOffset(28800);
  temp.begin();//Start the DS18B20 sensor(溫度)

  Serial.print("Connecting to SQL...  ");
  if (conn.connect(server_addr, 3306, user, password))         // 連接數據庫
    Serial.println("OK.");   
  else
    Serial.println("FAILED.");
  cursor = new MySQL_Cursor(&conn);    // 創建一個數據庫遊標實例
}

void loop()
{
  readAndRecordData();        
  delay(5000);
}
