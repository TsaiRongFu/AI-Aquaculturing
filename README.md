# AI-Aquaculturing

A project that uses a camera to combine artificial intelligence and image recognition to identify the situation  

Thematic works of four students from the Department of Information Management, National Pingtung University of Science and Technology

## 首先配置系統環境


* 安裝Anaconda
  https://www.anaconda.com/products/individual
  
  配置Anacond主要是為了簡單化安裝必要用到之套件，減少新手配置環境變數遇到之困難，另外Anaconda有著Managing environments，確保當環境配置出錯時不影響主系統

  另外如果您是對環境配置熟練不過的高手，可以跳過安裝Anaconda，照著接下來的教學中出現的套件自行安裝
  
  ![Anaconda](https://www.anaconda.com/wp-content/uploads/2018/06/cropped-Anaconda_horizontal_RGB-1-600x102.png)

---
1. 當您安裝完成Anaconda後，我們開始創建一個新的環境

   * 打開您的Command OR Terminal並輸入以下指令，創建名為train的新環境python版本為3.5
   
     `conda create -n train pip python=3.5`  <br><br>
  
2. 當您創建完成後透過以下指令來確認您是否有成功創建，下圖為成功畫面
    * 打開您的Command OR Terminal並輸入以下指令

      `conda env list`

      ![conda env list](https://github.com/cairongfu/AI-Aquaculturing/blob/main/ReadmePicture/Anaconda_Create_Env.JPG)
---
1. 當您安裝完成Anaconda後，我們開始創建一個新的環境

   * 打開您的Command OR Terminal並輸入以下指令，創建名為train的新環境python版本為3.5
   
     `conda create -n train pip python=3.5`  <br><br>
  
*當您創建完成後透過以下指令來確認您是否有成功創建，下圖為成功畫面
**`conda env list`
***![conda env list](https://github.com/cairongfu/AI-Aquaculturing/blob/main/ReadmePicture/Anaconda_Create_Env.JPG)
>>>>>>> abf50aeb5581dece006a731177e0e49c1f0584f8
  
  更多關於Anaconda管理環境指令可以參考以下網址
  https://docs.conda.io/projects/conda/en/latest/user-guide/tasks/manage-environments.html
# 參考這篇教學文件

https://gilberttanner.com/blog/convert-your-tensorflow-object-detection-model-to-tensorflow-lite

https://gilberttanner.com/blog/creating-your-own-objectdetector

https://gilberttanner.com/blog/installing-the-tensorflow-object-detection-api

python train.py --logtostderr --train_dir=training/ --pipeline_config_path=training/ssd_mobilenet_v2_quantized_300x300_coco.config

---

在anaconda建置新的環境參照下列網址做
https://docs.conda.io/projects/conda/en/latest/user-guide/tasks/manage-environments.html

conda create -n train pip python=3.5
conda activate train

---

首先找一個你喜歡的目錄把tensorflow-models git clone下來
 
git clone https://github.com/tensorflow/models 

- 打開Command :
 - Key入以下指令
 - python -m pip install --upgrade pip 
 - pip install tensorflow-gpu==1.15
 - conda install -c anaconda protobuf
 - pip install Cython
 - pip install contextlib2 
 - pip install pillow
 - pip install lxml
 - pip install jupyter
 - pip install matplotlib
 - pip install opencv-python
 - pip install pandas

**基本上如果您安裝過  這些元件會都會安裝好一部分元件  但為了確保環境正確請各位在執行一次**
![Anaconda](https://www.anaconda.com/wp-content/uploads/2018/06/cropped-Anaconda_horizontal_RGB-1-600x102.png)

---

- 打開Command :
 - cd models\research
 - Key入以下指令
 - 每次重開command都要重設一次環境變數--**注意路徑位置**

```
set PYTHONPATH=C:\Users\RONGF\Desktop\modle\models;C:\Users\RONGF\Desktop\modle\models\research;C:\Users\RONGF\Desktop\modle\models\research\slim
```

 - Linux環境

```
export PYTHONPATH=/home/itriedgetpunpust/ipynb/TsaiJungFu/cai-train-path/models:/home/itriedgetpunpust/ipynb/TsaiJungFu/cai-train-path/models/research:/home/itriedgetpunpust/ipynb/TsaiJungFu/cai-train-path/models/research/slim
```

---

- 打開Command :
 - cd models\research
 - Key入以下指令

```
protoc --python_out=. .\object_detection\protos\anchor_generator.proto .\object_detection\protos\argmax_matcher.proto .\object_detection\protos\bipartite_matcher.proto .\object_detection\protos\box_coder.proto .\object_detection\protos\box_predictor.proto .\object_detection\protos\eval.proto .\object_detection\protos\faster_rcnn.proto .\object_detection\protos\faster_rcnn_box_coder.proto .\object_detection\protos\grid_anchor_generator.proto .\object_detection\protos\hyperparams.proto .\object_detection\protos\image_resizer.proto .\object_detection\protos\input_reader.proto .\object_detection\protos\losses.proto .\object_detection\protos\matcher.proto .\object_detection\protos\mean_stddev_box_coder.proto .\object_detection\protos\model.proto .\object_detection\protos\optimizer.proto .\object_detection\protos\pipeline.proto .\object_detection\protos\post_processing.proto .\object_detection\protos\preprocessor.proto .\object_detection\protos\region_similarity_calculator.proto .\object_detection\protos\square_box_coder.proto .\object_detection\protos\ssd.proto .\object_detection\protos\ssd_anchor_generator.proto .\object_detection\protos\string_int_label_map.proto .\object_detection\protos\train.proto .\object_detection\protos\keypoint_box_coder.proto .\object_detection\protos\multiscale_anchor_generator.proto .\object_detection\protos\graph_rewriter.proto .\object_detection\protos\calibration.proto .\object_detection\protos\flexible_grid_anchor_generator.proto
```

~~接著到下列網址下載protobuf工具(依照自身作業系統下載)~~

~~https://github.com/protocolbuffers/protobuf/releases~~

~~接著下載use_protobuf.py檔~~

~~[use_protobuf.py](https://trello.com/1/cards/5e95106ac42ee761ec1a911d/attachments/5e957d679b6f7a4c7d04c68a/download?backingUrl=https%3A%2F%2Ftrello-attachments.s3.amazonaws.com%2F5e6856f39a79a12665199a15%2F5e95106ac42ee761ec1a911d%2Fa6624a2e61cbf0896f81f551275073fb%2Fuse_protobuf.py)~~ 

~~- 打開Command :~~
~~ - cd 至 use_protobuf.py~~
~~ - Key入以下指令~~
~~ - python use_protobuf.py models/research/object_detection/protos~~
~~C:/Users/Eggs/Desktop/tensorflow/bin/protoc~~

~~```
    python use_protobuf.py 指定到剛剛下載的models下的protos 在指定存放protobuf工具的路徑
```~~

當您準備好protocolbu並且把.protobuf檔轉成.py檔後

---

- 打開Command :
 - cd 到您剛剛git clone 下來的models/research
 - Key入以下指令
 - python setup.py build
 - python setup.py install

Linux在install時錯誤把python更新到3.6

---

下載此ipynb檔並取代原來的object_detection_tutorial ipynb檔

[object_detection_tutorial.ipynb](https://trello-attachments.s3.amazonaws.com/5e6856f39a79a12665199a15/5e95106ac42ee761ec1a911d/47e97716398632b02c1493c826cd87f7/object_detection_tutorial.ipynb) 

- 打開Command :
 - cd 到您剛剛git clone 下來的models/research
 - Key入以下指令
 - jupyter notebook object_detection_tutorial.ipynb


---
##**注意接下來這個步驟可以選擇不做**
##**此步驟是為了簡化電腦運算的負擔**
　　
準備好您的圖片放在同一個資料夾

接著下載以下py檔
###**⇣⇣⇣⇣⇣⇣⇣⇣⇣⇣⇣⇣⇣⇣⇣⇣⇣⇣⇣⇣⇣**
###**[transform_image_resolution.py](https://trello.com/1/cards/5e95106ac42ee761ec1a911d/attachments/5e9511d9d333a51c33985b77/download?backingUrl=https%3A%2F%2Ftrello-attachments.s3.amazonaws.com%2F5e6856f39a79a12665199a15%2F5e95106ac42ee761ec1a911d%2Fb8d987f3d54237772f0829de8ae98a26%2Ftransform_image_resolution.py) **

- 打開Command :
 - cd 到您存放transform_image_resolution.py目錄底下
 - Key入以下指令
 - python transform_image_resolution.py -d images/ -s 800 600
```
    python 檔案名稱 -d 圖片檔案路徑 -s 圖片縮放比例
```

---
**接著標記所有圖片使用LbelImg**使用方法參照下面這邊就不多贅述了

[LabelImg 教學](https://github.com/tzutalin/labelImg)

[LabelImg Download](https://tzutalin.github.io/labelImg/)

---

####接著在images資料夾底下創建兩個新資料夾分別為

**test**     將20％ 的圖片數量放到test資料夾內(包含標記過後對應的XML檔)
**train**    將80％ 的圖片數量放到train資料夾內(包含標記過後對應的XML檔)

---

接著下載以下兩個py檔

如字面上意思將您的XML轉成CSV檔

注意以下code其中的 image_path路徑、xml_df.to_csv路徑，改為自己XML位置

下列★部分

###**[xml_to_csv.py](https://trello-attachments.s3.amazonaws.com/5e6856f39a79a12665199a15/5e95106ac42ee761ec1a911d/3f1c24f7a144f306e502a2fb2d01b95f/xml_to_csv.py) **

```
def main():
    for folder in ['train', 'test']:
  ★  image_path = os.path.join(os.getcwd(), ('images/' + folder))
        xml_df = xml_to_csv(image_path)
  ★  xml_df.to_csv(('images/'+folder+'_labels.csv'), index=None)
    print('Successfully converted xml to csv.')
```

- 打開Command :
 - cd 到您存放xml_to_csv.py目錄底下
 - Key入以下指令
 - python xml_to_csv.py

**
Successfully converted xml to csv.後會在您的images資料夾內出現兩個檔
**
分別如下：
'label_test'
'label_train'

---

###**[generate_tfrecord.py](https://trello-attachments.s3.amazonaws.com/5e6856f39a79a12665199a15/5e95106ac42ee761ec1a911d/268cdee44b44ff9624a0e72db60a72c1/generate_tfrecord.py) **

接著執行這個generate_tfrecord.py檔

**
注意以下code其中的 def class_text_to_int部分，這部分需要依照您要訓練的label新增，這邊我只訓練一類故此只有 Clownfish如要新增多label就自行增加**
 
```
if  row_label == 'label name':
       return able number(直接填寫數字)如下code
    elseif:
       ......
    else:
       None
```

下列★部分要特別注意填寫的內容
**‘label name'  **
**'return number'**

```
def class_text_to_int(row_label):
★   if row_label == 'Clownfish':
★     return 1
      else:
         None
```
- 打開Command :
 - cd 到您存放generate_tfrecord.py目錄底下
 - Key入以下指令
 - python generate_tfrecord.py --csv_input=images/train_labels.csv --image_dir=images/train --output_path=train.record
 - python generate_tfrecord.py --csv_input=images/test_labels.csv --image_dir=images/test --output_path=test.record

###**邊特別注意您存放test_labels.csv、train_labels.csv ，--csv_input路徑位置，如不一樣請自行修改**
---
##**接著創建一個labelmap.pdtxt檔案如下範例(可拿下面labelmap.pbtxt改)**

```
此處id數量和ID請與generate_tfrecord.py一致
item {
    id: 1
    name: 'ID'
}
item {
    id: 2
    name: 'ID'
}
item {
    id: 3
    name: 'ID'
}
item {
    id: 4
    name: 'ID'
}
```
###**[labelmap.pbtxt](https://trello.com/1/cards/5e95106ac42ee761ec1a911d/attachments/5e95630c6c00820229eb32e8/download?backingUrl=https%3A%2F%2Ftrello-attachments.s3.amazonaws.com%2F5e6856f39a79a12665199a15%2F5e95106ac42ee761ec1a911d%2F8c1f4d05173cd40e69ec33941f98da12%2Flabelmap.pbtxt) **
---

接著到models\research\object_detection底下

- 打開Command :
 - cd models\research\object_detection
 - Key入以下指令
 - ` mkdir training`

接著到models\research\object_detection\samples\configs底下找到您要的訓練模型config複製到剛剛新增的training資料夾內

#**注意目前僅接受**
#**ssd_mobilenet_v2_quantized_300x300_coco.config**
#**否則訓練出來模型會有問題**

**在將labelmap.pbtxt也複製到training資料夾內**
---
到以下找您要訓練的模型並且下載下來放置在你喜愛的路徑下

#**注意目前僅接受**
#**ssd_mobilenet_v2_quantized_coco 這個模型**
#**否則訓練出來模型會有問題**

https://github.com/tensorflow/models/blob/master/research/object_detection/g3doc/detection_model_zoo.md
---

修改config檔設定

model 內的 num_classes數量由您要訓練的label決定

```
model {
  ssd {
    num_classes: 1
    box_coder {
      faster_rcnn_box_coder {
        y_scale: 10.0
        x_scale: 10.0
        height_scale: 5.0
        width_scale: 5.0
      }
    }
```
---

fine_tune_checkpoint: 路徑就設定在剛剛下載的tensorflow zoo下載的模型位置
在最後加上model.ckpt

```
fine_tune_checkpoint: "C:/Users/RONGF/Desktop/modle/models/research/object_detection/ssdlite_mobilenet_v2_coco_2018_05_09/model.ckpt"
```

---

 input_path:放入您的train.record路徑

 label_map_path:放入您的labelmap.pbtxt路徑

```
train_input_reader: {
  tf_record_input_reader {
    input_path: "C:/Users/RONGF/Desktop/modle/train.record"
  }
  label_map_path: "C:/Users/RONGF/Desktop/modle/models/research/object_detection/training/labelmap.pbtxt"
}
```

---

此處的input_path放入test.record路徑

 label_map_path:放入您的labelmap.pbtxt路徑

```
eval_input_reader: {
  tf_record_input_reader {
    input_path: "C:/Users/RONGF/Desktop/modle/test.record"
  }
  label_map_path: "C:/Users/RONGF/Desktop/modle/models/research/object_detection/training/labelmap.pbtxt"
  shuffle: false
  num_readers: 1
}
```

---
最後進行模型訓練
到models\research\object_detection\legacy\train複製這支py檔到models\research\object_detection目錄下

- 打開Command :
 - cd models\research\object_detection
 - Key入以下指令
 - 如下路徑請自行轉換成您自己的路徑-和自己的config檔名稱

```
python train.py --logtostderr --train_dir=training/ --pipeline_config_path=training/config模型名稱.config
```

---

 -  No module named 'absl'
  - cmd key 
  - pip install absl-py 

 - No module named 'tensorflow'
  - cmd key
  - pip install tensorflow==1.15  
 
 -  No module named 'pycocotools'
  - cmd key
  - pip install "git+https://github.com/philferriere/cocoapi.git#egg=pycocotools&subdirectory=PythonAPI"

 -  cannot import name 'anchor_generator_pb2' from 'object_detection.protos' (C:\Users\Eggs\anaconda3\lib\site-packages\object_detection-0.1-py3.7.egg\object_detection\protos\__init__.py)
  - cmd key
  - cd 
  - C:/Users/Eggs/Desktop/tensorflow/bin/proto這裡指的是剛剛protoc.exe路徑
  - --python_out=./ 原地匯出py檔
  - research\object_detection\protos\*.proto轉換protos資料夾底下所有路徑
  - 接著進到 models\research\object_detection\protos資料夾內複製所有檔案至anaconda內的protos資料夾裡並取代所有

-  No module named 'nets'
 - cmd key 
 - cd models\research\slim 底下輸入
 - python setup.py build
 - python setup.py install
 - 如果build、install失敗請刪除資料夾內的BUILD檔再進行一次上述兩個指令
  
---

當模型訓練到您要的loss值之後Ctrl+c關閉後在training資料夾內會出現
接著開始凍結出模型

打開training資料夾找到model.ckpt-xxxxx檔案，選擇數字最高的檔案

- 打開Command :
 - cd C:\Users\RONGF\Desktop\modle\models\research\object_detection
 - Key入以下指令
 - python export_tflite_ssd_graph.py --input_type image_tensor --pipeline_config_path training/ssdlite_mobilenet_v2_coco.config --trained_checkpoint_prefix training/model.ckpt-XXXX --output_directory ssd_graph

```
python export_tflite_ssd_graph.py --input_type image_tensor --pipeline_config_path training/依照自己訓練的config檔名稱.config --trained_checkpoint_prefix training/model.ckpt-XXXX(最大數值) --output_directory ssd_graph(可行命名想要的資料夾名稱)
```
---

成功之後會在object_detection 資料夾內出現ssd_graph資料夾裡面會有tflite_graph.pb檔接著開始轉型成tflite檔

---
參照下列網址建置Tensorflow

建議您在anaconda建置新的環境參照下列網址做
https://docs.conda.io/projects/conda/en/latest/user-guide/tasks/manage-environments.html

conda create -n tensorflow pip python=3.6
conda activate tensorflow

接著再跟著下列網址做
https://www.tensorflow.org/install/source_windows

首先配置環境安裝以下檔案

[vs_buildtools.exe](https://trello-attachments.s3.amazonaws.com/5e6856f39a79a12665199a15/5e95106ac42ee761ec1a911d/51081d5a8b8ec951efe2f2afadf8aa7c/vs_buildtools.exe) 

[vc_redist.x86](https://drive.google.com/file/d/1ZC-5g6hPiw4h0-MkJln75iNZbk03Dy0m/view?usp=sharing)

[MSYS2](http://repo.msys2.org/distrib/x86_64/msys2-x86_64-20190524.exe)

[bazel](https://github.com/bazelbuild/bazel/releases/download/0.26.1/bazel-0.26.1-windows-x86_64.zip)

[Tensorflow](https://github.com/tensorflow/tensorflow/archive/v1.15.0.zip)

###**當您執行到**
```
bazel build //tensorflow/tools/pip_package:build_pip_package
```
###**最後報錯這是沒有關西的**

---

接著不要關掉Command執行

```
bazel run --config=opt tensorflow/lite/toco:toco
```
###**這部分會Build成功!!**

接著把剛剛訓練出來的pd檔放到MSYS2安裝路徑下msys64資料夾底下

---

###**一樣Command執行以下指令**

如果之前已build過的人請到當時 git clone 的位置底下

###**注意下面路徑和檔案名稱請對應自身的路徑和名稱如還不懂請參照下列網址2.3點使用TOCO創建優化的TensorFlow Lite模型步驟**
 https://gilberttanner.com/blog/convert-your-tensorflow-object-detection-model-to-tensorflow-lite

``` 
bazel run --config=opt tensorflow/lite/toco:toco -- --input_file=/tflite_graph.pb --output_file=/detect.tflite --input_shapes=1,300,300,3 --input_arrays=normalized_input_image_tensor --output_arrays=TFLite_Detection_PostProcess,TFLite_Detection_PostProcess:1,TFLite_Detection_PostProcess:2,TFLite_Detection_PostProcess:3 --inference_type=QUANTIZED_UINT8 --mean_values=128 --std_values=128 --change_concat_input_ranges=false --allow_custom_ops --default_ranges_min=0 --default_ranges_max=255
```

##**成功之後會在MSYS2安裝路徑下msys64資料夾底下出現detect.tflite檔檔案大小會縮小表成功**

---

為了讓tflite在edage TPU上運行速度正常請參照下列文章在編譯一次模型

**此步驟在Ubuntu、Linux環境下運作會方便很多，請不要自虐在windows做**

[Coral Edge Tpu compiler](https://coral.ai/docs/edgetpu/compiler/)

因此步驟極度簡單就不加以說明參照官方文件做就行了

此步驟完成後會在同一個路徑下出現detect_degetpu.tflite  這就是最後模型了

---

   #**恭喜您成功完成了**
   #**有任何文題請參照最上面三個網址**
   #**若還有問題麻煩留言**
