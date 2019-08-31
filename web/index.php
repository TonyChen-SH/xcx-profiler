<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<div id="header">
    我的头部
</div>
<div id="container">
    <div class="tools">
        工具箱
        <input type="button" onclick="scan()" value="扫描">
    </div>
    <div class="path">
        <label for="">
            路径 <input type="text" name="scanPath" placeholder="输入项目完整路径"
                      value="/Users/chendan/Project/work-jooj/baodao_member_plus"
                      style="width: 700px">
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
</body>
<script>
    // 扫描
    function scan() {
        let scanPath = document.getElementsByName('scanPath')[0].value;
        document.getElementById('profiler').src = 'scan.php?scanPath=' + scanPath;
    }
</script>
</html>