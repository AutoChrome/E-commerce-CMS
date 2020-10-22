<?php
header("Content-type: text/css; charset: UTF-8");
$configs = json_decode(file_get_contents("../configs/config.json"), true);
?>
.container{
    position:relative;
    min-height:100%;
}
.body{
    padding-bottom:140px;
}

.content-border{
    padding: 1rem;
    margin: 1rem;
    border: 1px solid #cacaca;
    border-radius: 1rem;
}

.primary-colour{
    background-color:<?php echo $configs[0]["primary-colour"]; ?>;
}

.content{
    padding:1rem;
}

.title-bar{
    background-color:<?php echo $configs[0]["primary-colour"];?>;
    color:<?php echo $configs[0]["accent-colour"];?>;
}

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

.top-bar-mid{
    flex: 45 5 auto;
}

.flex-container{
    display:flex;
    justify-content: center;
}

.top-bar .top-bar-mid input{
    flex-grow: 20;
    max-width:none;
}

.top-bar-mid .input-group-label{
    flex-grow:1;
}

.top-bar-mid .input-group{
    margin-bottom:0px;
}

.top-bar .top-bar-mid .menu{
    background-color:<?php echo $configs[0]["primary-colour"];?>;
}

.top-bar .top-bar-mid .menu a{
    color:<?php echo $configs[0]["accent-colour"];?>;
}

.top-bar .top-bar-right .menu{
    background-color:<?php echo $configs[0]["primary-colour"]?>;
    color:<?php echo $configs[0]["accent-colour"];?>;
}
.top-bar .top-bar-right .menu  a{
    color:<?php echo $configs[0]["accent-colour"];?>;
}

.menu .menu-text{
    padding:0px;
}

.button.primary, .button[disabled].primary{
    background-color:<?php echo $configs[0]['button-colour'];?>;
}

.button.primary:hover,
.button.primary:focus{
    background-color:<?php echo $configs[0]['button-colour-hover'];?>;
}

.overflow{
    overflow-x:scroll;
    height:570px;
}

.filters{
    border-right: 1px solid #cacaca;
    padding: 1rem;
}

.fa-star, .fa-star-half-alt{
    color: #ffbd23;
}

/* class applies to select element itself, not a wrapper element */
.select-css {
    display: block;
    font-size: 16px;
    font-family: sans-serif;
    font-weight: 700;
    color: #444;
    line-height: 1.3;
    padding: .6em 1.4em .5em .8em;
    width: 15%;
    max-width: 100%; /* useful when width is set to anything other than 100% */
    box-sizing: border-box;
    margin: 0;
    border: 1px solid #aaa;
    box-shadow: 0 1px 0 1px rgba(0,0,0,.04);
    border-radius: .5em;
    background-color: #fff;
}
/* Hide arrow icon in IE browsers */
.select-css::-ms-expand {
    display: none;
}
/* Hover style */
.select-css:hover {
    border-color: #888;
}
/* Focus style */
.select-css:focus {
    border-color: #aaa;
    /* It'd be nice to use -webkit-focus-ring-color here but it doesn't work on box-shadow */
    box-shadow: 0 0 1px 3px rgba(59, 153, 252, .7);
    box-shadow: 0 0 0 3px -moz-mac-focusring;
    color: #222; 
    outline: none;
}

/* Set options to normal weight */
.select-css option {
    font-weight:normal;
}

/* Support for rtl text, explicit support for Arabic and Hebrew */
*[dir="rtl"] .select-css, :root:lang(ar) .select-css, :root:lang(iw) .select-css {
    background-position: left .7em top 50%, 0 0;
    padding: .6em .8em .5em 1.4em;
}

.card-padding{
    padding:1rem;
}

.thumbnail{
    height:300px;
    width:400px;
}

.footer{
    position:absolute;
    bottom: 0;
    height:120px;
    width:100%;
    background-color:#000;
    padding-top:1rem;
    color:#888;
}

.end-of-footer{
    background-color:gray;
    color: #000;
    padding-top:1rem;
}

.cookie_request{
    text-align:center;
    position:fixed;
    bottom:0;
    height:9rem;
    border: 0.5px solid #cacaca;
    background-color:#fefefe;
    width:100%;
    z-index:999999999;
    padding:1rem;
}

.cookie_request p{
    margin-bottom:0rem;
}