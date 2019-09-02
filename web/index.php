<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/materialize.css">
    <link rel="stylesheet" href="css/index.css">
    <script src="js/vue.js"></script>
</head>
<body>
<div class="container" id="app">
    <div id="header">
        <!--        我的头部-->
    </div>
    <div id="panel">
        <div class="tools">
            <span class="scanType">
                <label>
                    <input type="radio" class="with-gap" value="imageNotRef" v-model="scanType">
                    <span>未使用的图片</span>
                </label>
            </span>
            <span class="scanType">
                 <label>
                    <input type="radio" class="with-gap" value="jsNotRef" v-model="scanType">
                    <span>未使用的JS</span>
                </label>
            </span>
            <span class="scanType">
                <label>
                    <input type="radio" class="with-gap" value="imageNotUploadToRemote" v-model="scanType">
                    <span>图片未上传至远端</span>
                </label>
            </span>
            <span class="scanType">
                 <label>
                    <input type="radio" class="with-gap" value="customize" v-model="scanType">
                    <span>自定义</span>
                </label>
            </span>
            <span class="scan">
                <button class="scanButton waves-effect waves-light btn" @click="scan()">扫描</button>
            </span>
        </div>
        <div class="path">
            <label for="">
                <label>
                    <span>路径</span>

                    <input placeholder="输入项目完整路径" id="first_name" type="text" v-model="scanPath" style="width: 700px">
                </label>

            </label>
        </div>
        <div class="output">
            <div>
                <iframe id="profiler"></iframe>
            </div>
            <div>
            <span>
                <a href="#">导出</a>
            </span>
            </div>
        </div>
    </div>
    <div id="footer">
        <!--        我是底部-->
    </div>
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