<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/index.css">
    <script src="js/vue.js"></script>
</head>
<body>
<div class="container" id="app">
    <div id="header">
        我的头部
    </div>
    <div id="panel">
        <div class="tools">
            <div style="display: inline-block">
                <span class="scanType">
                    <input type="radio" id="imageNotRef" value="imageNotRef" v-model="scanType">
                    <label for="imageNotRef">未使用的图片</label>
                </span>
                <span class="scanType">
                    <input type="radio" id="jsNotRef" value="jsNotRef" v-model="scanType">
                     <label for="jsNotRef">未使用的JS</label>
                </span>
                <span class="scanType">
                    <input type="radio" id="imageNotUploadToRemote"
                           value="imageNotUploadToRemote" v-model="scanType">
                    <label for="imageNotUploadToRemote">图片未上传至远端</label>
                </span>
                <span class="scanType">
                    <input type="radio" id="customize" value="customize" v-model="scanType">
                    <label for="customize">自定义</label>
                </span>
            </div>
            <div style="display: inline-block">
                <input type="button" value="扫描" @click="scan()">
            </div>
        </div>
        <div class="path">
            <label for="">
                路径 <input type="text" name="scanPath" placeholder="输入项目完整路径" v-model="scanPath" style="width: 700px">
            </label>

        </div>
        <div class="output">
            <div>
                <iframe id="profiler" width="1000" height="600"></iframe>
            </div>
            <div>
            <span>
                <a href="#">导出</a>
            </span>
            </div>
        </div>
    </div>
    <div id="footer">我是底部</div>
</div>
</body>
<script>
    let app = new Vue({
        el: '#app',
        data: {
            scanType: 'imageNotRef',
            scanPath: '/Users/chendan/Project/work-jooj/baodao_member_plus'
        },
        methods: {
            /**
             *  扫描
             */
            scan: function () {
                document.getElementById('profiler').src = 'scan.php?scanPath=' + this.scanPath + '&scanType=' + this.scanType;
            }
        }
    });
</script>
</html>