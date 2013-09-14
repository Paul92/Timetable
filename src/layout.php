<!DOCTYPE html>

<head>
    <style>
    #menu{
        background-color: #C0C0C0;
        font-family: "Times New Roman", Times, serif;
        font-size: 30px;
        width: 220px;
        height: 300px;
        float:left;
    }
    #content{
        background-color: #CC99FF;
        font-family: "Times New Roman", Times, serif;
        font-size: 20px;
        width: 820px;
        height: 800px;
        float:left;
        position: relative;
        left: 10px;
    }
    </style>

    <title> <?php echo $title; ?> </title>
</head>

<body>
    <div id="menu">
        <?php echo $menu; ?>
    </div>

    <div id="content">
        <?php include __DIR__.'/pages/'.$content; ?>
    </div>
</body>

</html>
