<!DOCTYPE html>
<html lang="ru">
<head>
    [head]
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-6 my-4 offset-md-3 col-10 offset-1">
            [component]
        </div>
    </div>
</div>


<style>
html {
    min-height: 100%;
    width: 100%;
}
body {
    background:#FFFFFF;
    font-family:'Verdana', sans-serif;
    font-size:13px;
    color:#3B3B3B;
}

h1 {
    font-size:2.5em; 
    font-weight: bold;
    background: linear-gradient(90deg, rgba(46,56,41,1) 0%, rgba(109,179,79,1) 51%, rgba(46,56,41,1) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent; 
}

#content {
    margin-bottom:15px;
    border:1px solid #E7DFD7;
    border-radius:8px;
    background:#F8F8F8;
    padding:30px 40px;
    box-shadow: 2px 2px 20px rgb(54, 112, 64);
}

label {
    font-weight: bold;
}

input[type=text], input[type=password] {
    background-color: rgba(44, 192, 49, 0.233);
}

input[type=text]:focus, input[type=password]:focus {
    background-color: rgba(44, 192, 49, 0.233);
    outline: none;
}

.btn-success {
    font-weight: bold;
    background-color: rgba(46, 175, 53, 0.781);
    box-shadow: 0px 0px 5px rgb(39, 114, 43);
    border: none;
}
</style>

</body>
</html>
