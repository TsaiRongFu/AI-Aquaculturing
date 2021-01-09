# edgeTPU_backup
## 檔案位置
```
/usr/lib/python3/dist-packages/edgetpuvision/
```
```
sudo nano detect.py
```

## 執行命令
```
edgetpu_detect --source /dev/video1:YUY2:1280x720:10/1 --model detect_edgetpu.tflite --displaymode window
```


## 執行測試
```
edgetpu_detect_server \
--source /dev/video1:YUY2:1280x720:24/1  \
--model detect_edgetpu.tflite
```

## 更改辨識網頁port
```
cd /usr/lib/python3/dist-packages/edgetpuvision/streaming
```
```
sudo nano server.py
```


## 須先安裝的套件
```
pip3 install pytz
pip3 install mysql-connector-python
```
