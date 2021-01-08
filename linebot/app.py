import configparser #匯入config套件
#mysql套件
import pymysql

#flask框架套件
from flask import Flask, request, abort

#linebot套件
from linebot import (
    LineBotApi, WebhookHandler
)
from linebot.exceptions import (
    InvalidSignatureError
)
from linebot.models import (
    MessageEvent, TextMessage, TextSendMessage,ImageSendMessage,TemplateSendMessage,ButtonsTemplate,MessageTemplateAction,PostbackTemplateAction, PostbackEvent
)

#config檔案匯入
config = configparser.ConfigParser()
config.read("../config.ini")

app = Flask(__name__)
userjurid =0
config = configparser.ConfigParser()
config.read("config.ini")
line_bot_api = LineBotApi(config['line_bot']['Channel_Access_Token']) 
handler = WebhookHandler(config['line_bot']['Channel_Secret'])




# 監聽所有來自 /callback 的 Post Request
@app.route("/callback", methods=['POST'])
def callback():
    # get X-Line-Signature header value
    signature = request.headers['X-Line-Signature']

    # get request body as text
    body = request.get_data(as_text=True)
    app.logger.info("Request body: " + body)

    # handle webhook body
    try:
        handler.handle(body, signature)
    except InvalidSignatureError:
        print("Invalid signature. Please check your channel access token/channel secret.")
        abort(400)

    return 'OK'

def connect():
    dbconnect=pymysql.connect(host=(config['mysql']['host']),
                              user=(config['mysql']['user']),
                              password=(config['mysql']['password']),
                              db=(config['mysql']['db']))
    return dbconnect

def getuserjarid():
    email = "t@gmail.com"
    db=connect()
    cursor=db.cursor()
    sql = "SELECT "+ "userjarid" +" FROM " + "users " + "WHERE email=" + '\"' + email +'\"' 
    print(sql)
    cursor.execute(sql)
    userjarid= str(cursor.fetchone()[0])
    userjaridlist = userjarid.split(',')
    return userjaridlist

def getsensor(datajarid):
    db=connect()
    cursor=db.cursor()
    sql = "SELECT "+ "*" +" FROM " + "sensor" + " WHERE jarid ="+ datajarid +" ORDER BY dayStamp DESC"
    cursor.execute(sql)
    keylist= cursor.fetchone()
    dayStamp = keylist[0]
    timeStamp = keylist[1]
    jarid = keylist[2]
    waterlavel = keylist[3]
    temperature = keylist[4]
    PH = keylist[5]
    content="魚缸編號:"+jarid+"\n日期:"+dayStamp+"\n時間："+timeStamp+"\n酸鹼值："+str(PH)+"\n溫度："+str(temperature)+"\n水位高:"+waterlavel
    return content
def backimage(imgjarid):
    db=connect()
    cursor=db.cursor()
    sql = "SELECT "+ "*" +" FROM " + "line_bot_image_url" + " WHERE jarid ="+ imgjarid +" ORDER BY timestamp DESC"
    cursor.execute(sql)
    keylist= cursor.fetchone()
    imgurl = keylist[1]
    return imgurl

# 處理訊息
@handler.add(MessageEvent, message=TextMessage)
def handle_message(event):
    print("event.reply_token:", event.reply_token)
    print("event.message.text:", event.message.text)

    # if event.message.text == "水質數值":
    #     content = getsensor()
    #     line_bot_api.reply_message(
    #         event.reply_token,
    #         TextSendMessage(text=content))
    #     return 0
    if event.message.text == "水質數值": 

        userjaridlist = getuserjarid()
        actionslist = ""
        for i in range(len(userjaridlist)):
            actionslist+="PostbackTemplateAction(label='魚缸:"+userjaridlist[i]+"',text='水質數值-選擇魚缸:"+userjaridlist[i]+"',data='A&"+userjaridlist[i]+"'),"
        actionslist=actionslist[:-1]
        actionslist = "[" + actionslist + "]"

        line_bot_api.reply_message(  # 樣板按鈕功能
            event.reply_token,
            TemplateSendMessage(
                alt_text='水質數值-選擇魚缸',
                template=ButtonsTemplate(
                    title='水質數值-選擇魚缸編號',
                    text='水質數值-選擇魚缸',
                    actions = 
                        eval(actionslist)      
                )  
            )
        )
    if event.message.text == "活動力圖表":
        userjaridlist = getuserjarid()
        actionslist = ""
        for i in range(len(userjaridlist)):
            actionslist+="PostbackTemplateAction(label='魚缸:"+userjaridlist[i]+"',text='活動力圖表-選擇魚缸:"+userjaridlist[i]+"',data='B&"+userjaridlist[i]+"'),"
        actionslist=actionslist[:-1]
        actionslist = "[" + actionslist + "]"  

        line_bot_api.reply_message(  # 樣板按鈕功能
            event.reply_token,
            TemplateSendMessage(
                alt_text='活動力圖表-選擇魚缸',
                template=ButtonsTemplate(
                    title='活動力圖表-選擇魚缸編號',
                    text='活動力圖表-選擇魚缸',
                    actions = 
                        eval(actionslist)      
                )  
            )
        )    
    if event.message.text == "即時串流影像": 
        userjaridlist = getuserjarid()
        actionslist = ""
        for i in range(len(userjaridlist)):
            actionslist+="PostbackTemplateAction(label='串流影像:"+userjaridlist[i]+"',text='串流影像-選擇魚缸:"+userjaridlist[i]+"',data='C&"+userjaridlist[i]+"'),"
        actionslist=actionslist[:-1]
        actionslist = "[" + actionslist + "]" 

        line_bot_api.reply_message(  # 樣板按鈕功能
            event.reply_token,
            TemplateSendMessage(
                alt_text='即時串流影像-選擇魚缸',
                template=ButtonsTemplate(
                    title='即時串流影像-選擇魚缸編號',
                    text='即時串流影像-選擇魚缸',
                    actions = 
                        eval(actionslist)      
                )  
            )
        )

@handler.add(PostbackEvent)#  處理PostbackTemplateAction回傳值
def handle_postback(event):
    #水質數據回傳 關鍵字為A
   if event.postback.data[0:1] == "A":
        datajarid = str(event.postback.data[2:])
        content  = getsensor(datajarid)
        newcontent = ''.join(map(str,content))
        line_bot_api.reply_message(
            event.reply_token,
            TextSendMessage(text=newcontent))
    #活動力圖表回傳 關鍵字為B
   if event.postback.data[0:1] == "B":
        imgjarid = str(event.postback.data[2:])
        imgurl  = backimage(imgjarid)
        line_bot_api.reply_message(
            event.reply_token,
            ImageSendMessage(original_content_url=imgurl ,preview_image_url=imgurl))
    #串流影像網址回傳 關鍵字為C
   if event.postback.data[0:1] == "C":
        videojarid = str(event.postback.data[2:])

        if videojarid == "1":
            videourl = "http://140.127.22.134:3389"
        elif videojarid =="2":
            videourl = "http://140.127.22.135:3389"

        line_bot_api.reply_message(
            event.reply_token,
            TextSendMessage(text=videourl))


if __name__ == "__main__":
    app.run()
    