<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>相関図</title>

  <style>
    #myCanvas {
      left: 0px;
      top: 0px;
    }

    .coms {
      left: 50px;
      top: 100px;
      width: 150px;
      height: 50px;
      line-height: 50px;
    }

    .main {
      left: 550px;
      top: 350px;
      width: 150px;
      height: 50px;
      line-height: 50px;
    }

    .coco {
      left: 550px;
      top: 100px;
      width: 150px;
      height: 50px;
      line-height: 50px;
    }

    .css1 {
      color: yellow;
      font-size: 30px;
      text-align: center;
      background-color: red;
    }

    .css2 {
      color: yellow;
      font-size: 30px;
      text-align: center;
      background-color: blue;
    }
  </style>

  <script>
    (function() {

      function drawLine() {
        var canvas = document.getElementById("myCanvas");

        if (!canvas || !canvas.getContext) {
          return false;
        }

        var ctx = canvas.getContext("2d");

        ctx.strokeStyle = "red";
        var targetElement1 = document.getElementById("target1");
        var targetElement2 = document.getElementById("target2");

        var clientRect1 = targetElement1.getBoundingClientRect();
        var clientRect2 = targetElement2.getBoundingClientRect();

        // 画面内の位置
        var x1 = clientRect1.left;
        var y1 = clientRect1.top;
        var x2 = clientRect2.left;
        var y2 = clientRect2.top;

        ctx.beginPath();
        ctx.moveTo(x1 + 150, y1 + 25);
        ctx.lineTo(x2 + 75, y1 + 25);
        ctx.closePath();
        ctx.stroke();


        ctx.beginPath();
        ctx.moveTo(x2 + 75, y1 + 25);
        ctx.lineTo(x2 + 75, y2);
        ctx.closePath();
        ctx.stroke();


        ctx.beginPath();
        ctx.moveTo(x2 + 75, y2);
        ctx.lineTo(x2 + 75 + 15, y2 - 20);
        ctx.closePath();
        ctx.stroke();

        ctx.beginPath();
        ctx.moveTo(x2 + 75, y2);
        ctx.lineTo(x2 + 75 - 15, y2 - 20);
        ctx.closePath();
        ctx.stroke();

        ctx.beginPath();
        ctx.moveTo(x2 + 75 + 15, y2 - 20);
        ctx.lineTo(x2 + 75 - 15, y2 - 20);
        ctx.closePath();
        ctx.stroke();


      }

      onload = drawLine;

    })();
  </script>

  <link rel="stylesheet" href="./lib/Bootstrap4/bootstrap.min.css" />
  <link rel="stylesheet" href="./lib/FontAwesome/css/all.css" />

</head>

<body>
  <div class="container-fluid">
    <ul class="nav nav-tabs">
      <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#item1">時系列１</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#item2">時系列２</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#item3">時系列３</a>
      </li>
    </ul>

    <div class="tab-content">
      <div class="tab-pane fade show active" id="item1">This is a text of item#1.</div>
      <div class="tab-pane fade" id="item2">This is a text of item#2.</div>
      <div class="tab-pane fade" id="item3">This is a text of item#3.</div>
    </div>

    <div class="fixed-bottom">
      <div class="card" style="width: 30rem">
        <div class="card-body">
          <div class="form-group row">
            <label class="col-sm-3 col-form-label">登場人物</label>
            <div class="col-sm-9">
              <select class="form-control" id="exampleFormControlSelect1">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-3 col-form-label">関係</label>
            <div class="col-sm-9">
              <select class="form-control" id="exampleFormControlSelect1">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-3 col-form-label">対象</label>
            <div class="col-sm-9">
              <select class="form-control" id="exampleFormControlSelect1">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
              </select>
            </div>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </div>
    </div>
  </div>
  <script src="./lib/jQuery/jquery-3.5.1.slim.min.js"></script>
  <script src="./lib/Bootstrap4/bootstrap.bundle.min.js"></script>
</body>

</html>