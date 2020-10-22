<?php
header("Content-type: text/css; charset: UTF-8");
$configs = json_decode(file_get_contents("../configs/config.json"), true);
?>

.top-bar{
    background-color:<?php echo $configs[0]["primary-colour"];?>;
    color:<?php echo $configs[0]["accent-colour"];?>;
}

.top-bar .top-bar-left .menu{
    background-color:<?php echo $configs[0]["primary-colour"];?>;
}
.top-bar .top-bar-left .menu a{
    color:<?php echo $configs[0]["accent-colour"];?>;
}

.top-bar .top-bar-right .menu{
    background-color:<?php echo $configs[0]["primary-colour"]?>;
    color:<?php echo $configs[0]["accent-colour"];?>;
}
.top-bar .top-bar-right .menu  a{
    color:<?php echo $configs[0]["accent-colour"];?>;
}

.button.primary{
    background-color:<?php echo $configs[0]['button-colour'];?>;
}
.button.primary:hover,
.button.primary:focus{
    background-color:<?php echo $configs[0]['button-colour-hover'];?>;
}
.button.success{
    color:white;
}
.button.success:hover{
    color:#fff;
}
.button.success:active{
    color:#fff;
}

.overflow{
    overflow-x:scroll;
    height:570px;
}

.content-holder{
    background-color:#ededed;
}
.tabs-content{
    background-color:#f9fafc;
    border: none;
}

.nav-item{
    font-family:Roboto, Segoe UI,Oxygen,Ubuntu,Cantarell,Fira Sans,Droid Sans,Helvetica Neue,Arial,sans-serif;
    font
    -size:18px;
}

.bd{
    border: 1px solid rgba(0, 0, 0, .0625);
    background-color:#fff;
}

.nav-item > a{
    font-size:18px;
    font-weight: 500;
    padding: 15px;
}

.content-padding{
    padding: 1rem;
    margin-left: 1rem;
    margin-right: 1rem;
}

.padding{
    padding:1rem;
}

button p i{
    margin-right:1rem;
}

.tag-table{
    overflow-y:scroll;
    height:150px;
}
.image{
    transition: .5s ease;
    height: 200px;
}
tr.table-row-header{
    background-color: #d3d3d3;
    color:black;
}