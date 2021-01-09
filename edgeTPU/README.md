# Edge Tpu 執行及環境介紹
這些是本專案編輯過的edgetpu檔案，目錄是在 /usr/lib/python3/dist-packages/edgetpuvision/ 底下，主要有異動的檔案有detect.py及server.py

## 須先在Edge Tpu中安裝的套件
```
pip3 install pytz
pip3 install mysql-connector-python
```

## detect檔案位置及介紹，需要先更改裡面資料庫連接設定，也可以依個人需求編輯其他項目
先移動到/usr/lib/python3/dist-packages/edgetpuvision/，並用nano編輯器開啟detect.py
```
cd /usr/lib/python3/dist-packages/edgetpuvision/
sudo nano detect.py
```

第60行到64行請先換成自己的資料庫
```
###connect mysql
hostname = 'hostname'
username = 'username'
password = 'password'
database = 'database'
```

第200行為辨識正確率大於多少要執行上傳資料庫的判斷，可以從0到1自行設定，0=0%、1=100%
```
if socre > 0.7:
```

第227行的'1'為上傳到資料庫中的label，可以依據這台edgetpu辨識的種類的label自行更換
```
data = ('1',"'"+positsion+"'","'"+str(thistime)+"'")
```

## 執行本地物件偵測
影像模型先命名為detect_edgetpu.tflite，放在EdgeTpu根目錄下，其中--displaymode window是視窗化執行的意思，不輸入會以全螢幕執行
```
edgetpu_detect --source /dev/video1:YUY2:1280x720:10/1 --model detect_edgetpu.tflite --displaymode window
```

## 更改server物件偵測port
```
cd /usr/lib/python3/dist-packages/edgetpuvision/streaming
sudo nano server.py
```
在第252行中，可以把4664換成自己需要的port
```
web_port=4664
```
### 最後執行起來並在瀏覽器中輸入edgetpu的實體ip及設定好的port就能及時觀看物件偵測的即時串流了

## 執行server物件偵測(外部可連)
影像模型先命名為detect_edgetpu.tflite，放在EdgeTpu根目錄下
```
edgetpu_detect_server \
--source /dev/video1:YUY2:1280x720:24/1  \
--model detect_edgetpu.tflite
```
