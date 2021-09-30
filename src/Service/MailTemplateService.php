<?php

namespace App\Service;

class MailTemplateService {
    /**
     * @param array $data
     * 
     * @return string
     */
    public function getUserCreated(array $data): string {
        return '
        <html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office"><head> 
  <meta charset="UTF-8"> 
  <meta content="width=device-width, initial-scale=1" name="viewport"> 
  <meta name="x-apple-disable-message-reformatting"> 
  <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
  <meta content="telephone=no" name="format-detection"> 
  <title></title> 
  <!--[if (mso 16)]>
    <style type="text/css">
    a {text-decoration: none;}
    </style>
    <![endif]--> 
  <!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]--> 
  <!--[if !mso]><!-- --> 
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i" rel="stylesheet"> 
  <!--<![endif]--> 
  <!--[if gte mso 9]>
<xml>
    <o:OfficeDocumentSettings>
    <o:AllowPNG></o:AllowPNG>
    <o:PixelsPerInch>96</o:PixelsPerInch>
    </o:OfficeDocumentSettings>
</xml>
<![endif]--> 
 <link rel="stylesheet" type="text/css" href="https://my.stripo.email/static/assets/css/minimalist/editor.css?t=F61A"><link href="https://fonts.googleapis.com/css?family=Arvo:400,400i,700,700i|Lato:400,400i,700,700i|Lora:400,400i,700,700i|Merriweather:400,400i,700,700i|Merriweather Sans:400,400i,700,700i|Noticia Text:400,400i,700,700i|Open Sans:400,400i,700,700i|Playfair Display:400,400i,700,700i|Roboto:400,400i,700,700i|Source Sans Pro:400,400i,700,700i" rel="stylesheet"><link href="https://my.stripo.email/static/assets/css/dev-custom-scroll.css" rel="stylesheet"><link href="https://my.stripo.email/static/assets/fonts/banner/fonts.css" rel="stylesheet"><link href="https://my.stripo.email/static/assets/css/jquery-ui.css" rel="stylesheet" type="text/css"><meta http-equiv="Content-Security-Policy" content="script-src \'self\' https://cdn-ckeditor.stripo.email https://staging.stripo.email https://plugins.stripo.email https://green.stripo.email https://stripo.email https://vimeo.com https://stripo-app.firebaseio.com https://stripo-app.firebaseapp.com  \'unsafe-eval\'; connect-src \'none\'; object-src \'none\'; form-action \'none\';"><link rel="stylesheet" href="https://my.stripo.email/static/assets/css/dev-preview-styles.css" class="esdev-internal-css"><link rel="stylesheet" href="https://my.stripo.email/static/assets/css/dev-preview-styles.css" class="esdev-internal-css"><style class="esdev-css">/* CONFIG STYLES Please do not delete and edit CSS styles below */
/* IMPORTANT THIS STYLES MUST BE ON FINAL EMAIL */
#outlook a {
	padding: 0;
}
.ExternalClass {
	width: 100%;
}
.ExternalClass,
.ExternalClass p,
.ExternalClass span,
.ExternalClass font,
.ExternalClass td,
.ExternalClass div {
	line-height: 100%;
}
.es-button {
	mso-style-priority: 100 !important;
	text-decoration: none !important;
}
a[x-apple-data-detectors] {
	color: inherit !important;
	text-decoration: none !important;
	font-size: inherit !important;
	font-family: inherit !important;
	font-weight: inherit !important;
	line-height: inherit !important;
}
.es-desk-hidden {
	display: none;
	float: left;
	overflow: hidden;
	width: 0;
	max-height: 0;
	line-height: 0;
	mso-hide: all;
}
[data-ogsb] .es-button {
	border-width: 0 !important;
	padding: 15px 30px 15px 30px !important;
}
[data-ogsb] .es-button.es-button-1629968913941 {
	padding: 15px 30px !important;
}
/*
END OF IMPORTANT
*/
s {
	text-decoration: line-through;
}
html,
body {
	width: 100%;
	font-family: \'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;
	-webkit-text-size-adjust: 100%;
	-ms-text-size-adjust: 100%;
}
table {
	mso-table-lspace: 0pt;
	mso-table-rspace: 0pt;
	border-collapse: collapse;
	border-spacing: 0px;
}
table td,
html,
body,
.es-wrapper {
	padding: 0;
	Margin: 0;
}
.es-content,
.es-header,
.es-footer {
	table-layout: fixed !important;
	width: 100%;
}
img {
	display: block;
	border: 0;
	outline: none;
	text-decoration: none;
	-ms-interpolation-mode: bicubic;
}
table tr {
	border-collapse: collapse;
}
p,
hr {
	Margin: 0;
}
h1,
h2,
h3,
h4,
h5 {
	Margin: 0;
	line-height: 120%;
	mso-line-height-rule: exactly;
	font-family: \'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;
}
p,
ul li,
ol li,
a {
	-webkit-text-size-adjust: none;
	-ms-text-size-adjust: none;
	mso-line-height-rule: exactly;
}
.es-left {
	float: left;
}
.es-right {
	float: right;
}
.es-p5 {
	padding: 5px;
}
.es-p5t {
	padding-top: 5px;
}
.es-p5b {
	padding-bottom: 5px;
}
.es-p5l {
	padding-left: 5px;
}
.es-p5r {
	padding-right: 5px;
}
.es-p10 {
	padding: 10px;
}
.es-p10t {
	padding-top: 10px;
}
.es-p10b {
	padding-bottom: 10px;
}
.es-p10l {
	padding-left: 10px;
}
.es-p10r {
	padding-right: 10px;
}
.es-p15 {
	padding: 15px;
}
.es-p15t {
	padding-top: 15px;
}
.es-p15b {
	padding-bottom: 15px;
}
.es-p15l {
	padding-left: 15px;
}
.es-p15r {
	padding-right: 15px;
}
.es-p20 {
	padding: 20px;
}
.es-p20t {
	padding-top: 20px;
}
.es-p20b {
	padding-bottom: 20px;
}
.es-p20l {
	padding-left: 20px;
}
.es-p20r {
	padding-right: 20px;
}
.es-p25 {
	padding: 25px;
}
.es-p25t {
	padding-top: 25px;
}
.es-p25b {
	padding-bottom: 25px;
}
.es-p25l {
	padding-left: 25px;
}
.es-p25r {
	padding-right: 25px;
}
.es-p30 {
	padding: 30px;
}
.es-p30t {
	padding-top: 30px;
}
.es-p30b {
	padding-bottom: 30px;
}
.es-p30l {
	padding-left: 30px;
}
.es-p30r {
	padding-right: 30px;
}
.es-p35 {
	padding: 35px;
}
.es-p35t {
	padding-top: 35px;
}
.es-p35b {
	padding-bottom: 35px;
}
.es-p35l {
	padding-left: 35px;
}
.es-p35r {
	padding-right: 35px;
}
.es-p40 {
	padding: 40px;
}
.es-p40t {
	padding-top: 40px;
}
.es-p40b {
	padding-bottom: 40px;
}
.es-p40l {
	padding-left: 40px;
}
.es-p40r {
	padding-right: 40px;
}
.es-menu td {
	border: 0;
}
.es-menu td a img {
	display: inline-block !important;
}
/* END CONFIG STYLES */
a {
	text-decoration: none;
}
p,
ul li,
ol li {
	font-family: \'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;
	line-height: 150%;
}
ul li,
ol li {
	Margin-bottom: 15px;
}
.es-menu td a {
	text-decoration: none;
	display: block;
	font-family: \'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;
}
.es-wrapper {
	width: 100%;
	height: 100%;
	background-image: ;
	background-repeat: repeat;
	background-position: center top;
}
.es-wrapper-color {
	background-color: #eeeeee;
}
.es-header {
	background-color: transparent;
	background-image: ;
	background-repeat: repeat;
	background-position: center top;
}
.es-header-body {
	background-color: #044767;
}
.es-header-body p,
.es-header-body ul li,
.es-header-body ol li {
	color: #ffffff;
	font-size: 14px;
}
.es-header-body a {
	color: #ffffff;
	font-size: 14px;
}
.es-content-body {
	background-color: #ffffff;
}
.es-content-body p,
.es-content-body ul li,
.es-content-body ol li {
	color: #333333;
	font-size: 15px;
}
.es-content-body a {
	color: #ed8e20;
	font-size: 15px;
}
.es-footer {
	background-color: transparent;
	background-image: ;
	background-repeat: repeat;
	background-position: center top;
}
.es-footer-body {
	background-color: #ffffff;
}
.es-footer-body p,
.es-footer-body ul li,
.es-footer-body ol li {
	color: #333333;
	font-size: 14px;
}
.es-footer-body a {
	color: #333333;
	font-size: 14px;
}
.es-infoblock,
.es-infoblock p,
.es-infoblock ul li,
.es-infoblock ol li {
	line-height: 120%;
	font-size: 12px;
	color: #cccccc;
}
.es-infoblock a {
	font-size: 12px;
	color: #cccccc;
}
h1 {
	font-size: 36px;
	font-style: normal;
	font-weight: bold;
	color: #333333;
}
h2 {
	font-size: 30px;
	font-style: normal;
	font-weight: bold;
	color: #333333;
}
h3 {
	font-size: 20px;
	font-style: normal;
	font-weight: bold;
	color: #333333;
}
.es-header-body h1 a,.es-content-body h1 a,.es-footer-body h1 a {
	font-size: 36px;
}
.es-header-body h2 a,.es-content-body h2 a,.es-footer-body h2 a {
	font-size: 30px;
}
.es-header-body h3 a,.es-content-body h3 a,.es-footer-body h3 a {
	font-size: 20px;
}
a.es-button, button.es-button {
	border-style: solid;
	border-color: #ed8e20;
	border-width: 15px 30px 15px 30px;
	display: inline-block;
	background: #ed8e20;
	border-radius: 5px;
	font-size: 16px;
	font-family: \'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;
	font-weight: bold;
	font-style: normal;
	line-height: 120%;
	color: #ffffff;
	text-decoration: none;
	width: auto;
	text-align: center;
}
.es-button-border {
	border-style: solid solid solid solid;
	border-color: transparent transparent transparent transparent;
	background: #ed8e20;
	border-width: 0px 0px 0px 0px;
	display: inline-block;
	border-radius: 5px;
	width: auto;
}
/* RESPONSIVE STYLES Please do not delete and edit CSS styles below. If you don\'t need responsive layout, please delete this section. */
@media only screen and (max-width: 600px) {
	p,
    ul li,
    ol li,
    a {
		line-height: 150% !important;
	}
	h1,h2,h3,h1 a,h2 a,h3 a {
		line-height: 120% !important;
	}
	h1 {
		font-size: 32px !important;
		text-align: center;
	}
	h2 {
		font-size: 26px !important;
		text-align: center;
	}
	h3 {
		font-size: 20px !important;
		text-align: center;
	}
	.es-header-body h1 a,.es-content-body h1 a,.es-footer-body h1 a {
		font-size: 32px !important;
	}
	.es-header-body h2 a,.es-content-body h2 a,.es-footer-body h2 a {
		font-size: 26px !important;
	}
	.es-header-body h3 a,.es-content-body h3 a,.es-footer-body h3 a {
		font-size: 20px !important;
	}
	.es-menu td a {
		font-size: 16px !important;
	}
	.es-header-body p,
    .es-header-body ul li,
    .es-header-body ol li,
    .es-header-body a {
		font-size: 16px !important;
	}
	.es-content-body p,.es-content-body ul li,.es-content-body ol li,.es-content-body a {
		font-size: 16px !important;
	}
	.es-footer-body p,
    .es-footer-body ul li,
    .es-footer-body ol li,
    .es-footer-body a {
		font-size: 16px !important;
	}
	.es-infoblock p,
    .es-infoblock ul li,
    .es-infoblock ol li,
    .es-infoblock a {
		font-size: 12px !important;
	}
	*[class="gmail-fix"] {
		display: none !important;
	}
	.es-m-txt-c,
    .es-m-txt-c h1,
    .es-m-txt-c h2,
    .es-m-txt-c h3 {
		text-align: center !important;
	}
	.es-m-txt-r,
    .es-m-txt-r h1,
    .es-m-txt-r h2,
    .es-m-txt-r h3 {
		text-align: right !important;
	}
	.es-m-txt-l,
    .es-m-txt-l h1,
    .es-m-txt-l h2,
    .es-m-txt-l h3 {
		text-align: left !important;
	}
	.es-m-txt-r img,
    .es-m-txt-c img,
    .es-m-txt-l img {
		display: inline !important;
	}
	.es-button-border {
		display: inline-block !important;
	}
	a.es-button, button.es-button {
		font-size: 16px !important;
		display: inline-block !important;
		border-width: 15px 30px 15px 30px !important;
	}
	.es-btn-fw {
		border-width: 10px 0px !important;
		text-align: center !important;
	}
	.es-adaptive table,
    .es-btn-fw,
    .es-btn-fw-brdr,
    .es-left,
    .es-right {
		width: 100% !important;
	}
	.es-content table,
    .es-header table,
    .es-footer table,
    .es-content,
    .es-footer,
    .es-header {
		width: 100% !important;
		max-width: 600px !important;
	}
	.es-adapt-td {
		display: block !important;
		width: 100% !important;
	}
	.adapt-img {
		width: 100% !important;
		height: auto !important;
	}
	.es-m-p0 {
		padding: 0px !important;
	}
	.es-m-p0r {
		padding-right: 0px !important;
	}
	.es-m-p0l {
		padding-left: 0px !important;
	}
	.es-m-p0t {
		padding-top: 0px !important;
	}
	.es-m-p0b {
		padding-bottom: 0 !important;
	}
	.es-m-p20b {
		padding-bottom: 20px !important;
	}
	.es-mobile-hidden,
    .es-hidden {
		display: none !important;
	}
	tr.es-desk-hidden,
    td.es-desk-hidden,
    table.es-desk-hidden {
		width: auto!important;
		overflow: visible!important;
		float: none!important;
		max-height: inherit!important;
		line-height: inherit!important;
	}
	tr.es-desk-hidden {
		display: table-row !important;
	}
	table.es-desk-hidden {
		display: table !important;
	}
	td.es-desk-menu-hidden {
		display: table-cell!important;
	}
	.es-menu td {
		width: 1% !important;
	}
	table.es-table-not-adapt,
    .esd-block-html table {
		width: auto !important;
	}
	table.es-social {
		display: inline-block !important;
	}
	table.es-social td {
		display: inline-block !important;
	}
}
/* END RESPONSIVE STYLES */
.es-p-default {
	padding-top: 20px;
	padding-right: 35px;
	padding-bottom: 0px;
	padding-left: 35px;
}
.es-p-all-default {
	padding: 0px;
}
</style></head><body class=""> 
  <div class="es-wrapper-color"> 
   <!--[if gte mso 9]>
			<v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
				<v:fill type="tile" color="#eeeeee"></v:fill>
			</v:background>
		<![endif]--> 
   <table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0"> 
    <tbody> 
     <tr> 
      <td class="esd-email-paddings ui-droppable" valign="top"> 
        
        
       <table class="es-content ui-draggable" cellspacing="0" cellpadding="0" align="center"> 
        <tbody> 
         <tr> 
          <td class="esd-stripe esd-frame esdev-disable-select esd-hover" align="center" esd-handler-name="stripeBlockHandler">
            <div class="esd-structure-type">
        
            </div><div class="esd-block-btn">
                    <div class="esd-more"><a><span class="es-icon-dot-3"></span></a></div>
                    
            <div class="esd-save" title="Save as module">
                <a><span class="es-icon-save"></span></a></div>
                    
                    <div class="esd-move ui-draggable-handle" title="Move">
                        <a><span class="es-icon-move"></span></a>
                    </div>
                    <div class="esd-copy ui-draggable-handle" title="Copy">
                        <a><span class="es-icon-copy"></span></a>
                    </div>
                    <div class="esd-delete" title="Delete">
                        <a><span class="es-icon-delete"></span></a>
                    </div>
                </div>
            <div class="esd-add-stripe">
                <a><span class="es-icon-plus"></span></a>
                <div class="esd-stripes-popover esd-hidden-right">
                    <div class="esd-popover-content">
                        
                                <div class="esd-stripe-preview" esd-element-name="structureType_100">
                                    
            <div class="col-xs-12">
                <a class="esd-structure-preview"></a>
            </div>
                                </div>
                                <div class="esd-stripe-preview" esd-element-name="structureType_50_50">
                                    
            <div class="col-xs-6">
                <a class="esd-structure-preview"></a>
            </div>
            <div class="col-xs-6">
                <a class="esd-structure-preview"></a>
            </div>
                                </div>
                                <div class="esd-stripe-preview" esd-element-name="structureType_33_33_33">
                                    
            <div class="col-xs-4">
                <a class="esd-structure-preview"></a>
            </div>
            <div class="col-xs-4">
                <a class="esd-structure-preview"></a>
            </div>
            <div class="col-xs-4">
                <a class="esd-structure-preview"></a>
            </div>
                                </div>
                                <div class="esd-stripe-preview" esd-element-name="structureType_25_25_25_25">
                                    
            <div class="col-xs-3">
                <a class="esd-structure-preview"></a>
            </div>
            <div class="col-xs-3">
                <a class="esd-structure-preview"></a>
            </div>
            <div class="col-xs-3">
                <a class="esd-structure-preview"></a>
            </div>
            <div class="col-xs-3">
                <a class="esd-structure-preview"></a>
            </div>
                                </div>
                                <div class="esd-stripe-preview" esd-element-name="structureType_33_66">
                                    
            <div class="col-xs-4">
                <a class="esd-structure-preview"></a>
            </div>
            <div class="col-xs-8">
                <a class="esd-structure-preview"></a>
            </div>
                                </div>
                                <div class="esd-stripe-preview" esd-element-name="structureType_66_33">
                                    
            <div class="col-xs-8">
                <a class="esd-structure-preview"></a>
            </div>
            <div class="col-xs-4">
                <a class="esd-structure-preview"></a>
            </div>
                                </div>
                    </div>
                </div>
            </div>
         
           <table class="es-content-body" width="600" cellspacing="0" cellpadding="0" align="center" esd-img-prev-src="" style="background-color: transparent;"> 
            <tbody class="ui-droppable"> 
             <tr class="ui-draggable"> 
              <td class="esd-structure es-p40t es-p35b es-p35r es-p35l esd-frame esdev-disable-select" style="background-color: rgb(247, 247, 247);" bgcolor="#f7f7f7" align="left" esd-handler-name="structureBlockHandler">
            <div class="esd-structure-type">
        
            </div><div class="esd-block-btn ">
                    <div class="esd-more"><a><span class="es-icon-dot-3"></span></a></div>
                    
            <div class="esd-save" title="Save as module">
                <a><span class="es-icon-save"></span></a></div>
                    
                    <div class="esd-move ui-draggable-handle" title="Move">
                        <a><span class="es-icon-move"></span></a>
                    </div>
                    <div class="esd-copy ui-draggable-handle" title="Copy">
                        <a><span class="es-icon-copy"></span></a>
                    </div>
                    <div class="esd-delete" title="Delete" disabled="disabled">
                        <a><span class="es-icon-delete"></span></a>
                    </div>
                </div> 
               <table width="100%" cellspacing="0" cellpadding="0"> 
                <tbody class="ui-droppable"> 
                 <tr class="ui-draggable"> 
                  <td class="esd-container-frame esd-frame esdev-disable-select esd-hover" width="530" valign="top" align="center" esd-handler-name="containerHandler">
            <div class="esd-structure-type">
        
            </div><div class="esd-block-btn">
                    <div class="esd-more"><a><span class="es-icon-dot-3"></span></a></div>
                    
            <div class="esd-save" title="Save as module">
                <a><span class="es-icon-save"></span></a></div>
                    
                    <div class="esd-move ui-draggable-handle" title="Move">
                        <a><span class="es-icon-move"></span></a>
                    </div>
                    <div class="esd-copy ui-draggable-handle" title="Copy">
                        <a><span class="es-icon-copy"></span></a>
                    </div>
                    <div class="esd-delete" title="Delete">
                        <a><span class="es-icon-delete"></span></a>
                    </div>
                </div> 
                   <table width="100%" cellspacing="0" cellpadding="0"> 
                    <tbody class="ui-droppable"> 
                     <tr class="ui-draggable"> 
                      <td class="esd-block-image es-p20t es-p25b es-p35r es-p35l esd-frame esdev-disable-select esd-draggable esd-block esd-hover" align="center" style="font-size: 0px;" esd-handler-name="imgBlockHandler"><div class="esd-block-btn">
                    <div class="esd-more"><a><span class="es-icon-dot-3"></span></a></div>
                    
                    
                    <div class="esd-move ui-draggable-handle" title="Move">
                        <a><span class="es-icon-move"></span></a>
                    </div>
                    <div class="esd-copy ui-draggable-handle" title="Copy">
                        <a><span class="es-icon-copy"></span></a>
                    </div>
                    <div class="esd-delete" title="Delete">
                        <a><span class="es-icon-delete"></span></a>
                    </div>

                </div>
<img src="https://www.carasante.com/wp-content/uploads/2021/04/logocarasante-e1450701241142.png" alt="ship" style="display: block;" title="ship" width="150">
</td> 
                     </tr> 
                     <tr class="ui-draggable"> 
                      <td class="esd-block-text es-p15b esd-frame esd-draggable esd-block esd-hover esdev-disable-select" align="center" esd-handler-name="textElementHandler" contenteditable="true"><div class="esd-block-btn" contenteditable="false">
                    <div class="esd-more"><a><span class="es-icon-dot-3"></span></a></div>
                    
                    
                    <div class="esd-move ui-draggable-handle" title="Move">
                        <a><span class="es-icon-move"></span></a>
                    </div>
                    <div class="esd-copy ui-draggable-handle" title="Copy">
                        <a><span class="es-icon-copy"></span></a>
                    </div>
                    <div class="esd-delete" title="Delete">
                        <a><span class="es-icon-delete"></span></a>
                    </div>
                </div><h2 style="color: #333333; font-family: \'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;">'. $data['firstName'] .', votre compte a été créé !</h2></td> 
                     </tr> 
                     <tr class="ui-draggable"> 
                      <td class="esd-block-text es-m-txt-l es-p20t esd-frame esd-draggable esd-block esd-hover esdev-disable-select" align="left" esd-handler-name="textElementHandler" contenteditable="true"><div class="esd-block-btn " contenteditable="false">
                    <div class="esd-more"><a><span class="es-icon-dot-3"></span></a></div>
                    
                    
                    <div class="esd-move ui-draggable-handle" title="Move">
                        <a><span class="es-icon-move"></span></a>
                    </div>
                    <div class="esd-copy ui-draggable-handle" title="Copy">
                        <a><span class="es-icon-copy"></span></a>
                    </div>
                    <div class="esd-delete" title="Delete">
                        <a><span class="es-icon-delete"></span></a>
                    </div>
                </div><h3 style="font-size: 18px;">Nous sommes ravi de vous acceuillir !</h3></td> 
                     </tr> 
                     <tr class="ui-draggable"> 
                      <td class="esd-block-text es-p15t es-p10b esd-frame esd-draggable esd-block esd-hover esdev-disable-select" align="left" esd-handler-name="textElementHandler" contenteditable="true"><div class="esd-block-btn" contenteditable="false">
                    <div class="esd-more"><a><span class="es-icon-dot-3"></span></a></div>
                    
                    
                    <div class="esd-move ui-draggable-handle" title="Move">
                        <a><span class="es-icon-move"></span></a>
                    </div>
                    <div class="esd-copy ui-draggable-handle" title="Copy">
                        <a><span class="es-icon-copy"></span></a>
                    </div>
                    <div class="esd-delete" title="Delete">
                        <a><span class="es-icon-delete"></span></a>
                    </div>
                </div><p style="font-size: 16px; color: #777777;">Pour activer votre compte, vous devez choisir un mot de passe.<br>​Cliquez sur le bouton ci-dessus.<br></p></td> 
                     </tr> 
                     <tr class="ui-draggable"> 
                      <td class="esd-block-button es-p25t es-p20b es-p10r es-p10l esd-frame esdev-disable-select esd-draggable esd-block esd-hover" align="center" esd-handler-name="btnBlockHandler"><div class="esd-block-btn">
                    <div class="esd-more"><a><span class="es-icon-dot-3"></span></a></div>
                    
                    
                    <div class="esd-move ui-draggable-handle" title="Move">
                        <a><span class="es-icon-move"></span></a>
                    </div>
                    <div class="esd-copy ui-draggable-handle" title="Copy">
                        <a><span class="es-icon-copy"></span></a>
                    </div>
                    <div class="esd-delete" title="Delete">
                        <a><span class="es-icon-delete"></span></a>
                    </div>
                </div><span class="es-button-border" style="background-color: rgb(0 184 221);"><a href="'. $_ENV['FRONT_URL'] . '/set-password/' . $data['token'] .'" class="es-button es-button-1629968913941" target="_blank" style="font-weight: normal; border-width: 15px 30px; color: rgb(255, 255, 255); font-size: 18px; background-color: rgb(0 184 221); border-color: rgb(0 184 221);">Activer mon compte</a></span></td> 
                     </tr> 
                    </tbody> 
                   </table></td> 
                 </tr> 
                </tbody> 
               </table></td> 
             </tr> 
              
            </tbody> 
           </table></td> 
         </tr> 
        </tbody> 
       </table> 
        
       <table class="es-footer ui-draggable" cellspacing="0" cellpadding="0" align="center"> 
        <tbody> 
         <tr> 
          <td class="esd-stripe esd-frame esdev-disable-select esd-hover" align="center" esd-handler-name="stripeBlockHandler">
            <div class="esd-structure-type">
        
            </div><div class="esd-block-btn">
                    <div class="esd-more"><a><span class="es-icon-dot-3"></span></a></div>
                    
            <div class="esd-save" title="Save as module">
                <a><span class="es-icon-save"></span></a></div>
                    
                    <div class="esd-move ui-draggable-handle" title="Move">
                        <a><span class="es-icon-move"></span></a>
                    </div>
                    <div class="esd-copy ui-draggable-handle" title="Copy">
                        <a><span class="es-icon-copy"></span></a>
                    </div>
                    <div class="esd-delete" title="Delete">
                        <a><span class="es-icon-delete"></span></a>
                    </div>
                </div>
            <div class="esd-add-stripe">
                <a><span class="es-icon-plus"></span></a>
                <div class="esd-stripes-popover esd-hidden-right">
                    <div class="esd-popover-content">
                        
                                <div class="esd-stripe-preview" esd-element-name="structureType_100">
                                    
            <div class="col-xs-12">
                <a class="esd-structure-preview"></a>
            </div>
                                </div>
                                <div class="esd-stripe-preview" esd-element-name="structureType_50_50">
                                    
            <div class="col-xs-6">
                <a class="esd-structure-preview"></a>
            </div>
            <div class="col-xs-6">
                <a class="esd-structure-preview"></a>
            </div>
                                </div>
                                <div class="esd-stripe-preview" esd-element-name="structureType_33_33_33">
                                    
            <div class="col-xs-4">
                <a class="esd-structure-preview"></a>
            </div>
            <div class="col-xs-4">
                <a class="esd-structure-preview"></a>
            </div>
            <div class="col-xs-4">
                <a class="esd-structure-preview"></a>
            </div>
                                </div>
                                <div class="esd-stripe-preview" esd-element-name="structureType_25_25_25_25">
                                    
            <div class="col-xs-3">
                <a class="esd-structure-preview"></a>
            </div>
            <div class="col-xs-3">
                <a class="esd-structure-preview"></a>
            </div>
            <div class="col-xs-3">
                <a class="esd-structure-preview"></a>
            </div>
            <div class="col-xs-3">
                <a class="esd-structure-preview"></a>
            </div>
                                </div>
                                <div class="esd-stripe-preview" esd-element-name="structureType_33_66">
                                    
            <div class="col-xs-4">
                <a class="esd-structure-preview"></a>
            </div>
            <div class="col-xs-8">
                <a class="esd-structure-preview"></a>
            </div>
                                </div>
                                <div class="esd-stripe-preview" esd-element-name="structureType_66_33">
                                    
            <div class="col-xs-8">
                <a class="esd-structure-preview"></a>
            </div>
            <div class="col-xs-4">
                <a class="esd-structure-preview"></a>
            </div>
                                </div>
                    </div>
                </div>
            </div>
         
           <table class="es-footer-body" width="600" cellspacing="0" cellpadding="0" align="center" esd-img-prev-src=""> 
            <tbody class="ui-droppable"> 
             <tr class="ui-draggable"> 
              <td class="esd-structure es-p35t es-p40b es-p35r es-p35l esd-frame esdev-disable-select esd-hover" align="left" esd-handler-name="structureBlockHandler">
            <div class="esd-structure-type">
        
            </div><div class="esd-block-btn">
                    <div class="esd-more"><a><span class="es-icon-dot-3"></span></a></div>
                    
            <div class="esd-save" title="Save as module">
                <a><span class="es-icon-save"></span></a></div>
                    
                    <div class="esd-move ui-draggable-handle" title="Move">
                        <a><span class="es-icon-move"></span></a>
                    </div>
                    <div class="esd-copy ui-draggable-handle" title="Copy">
                        <a><span class="es-icon-copy"></span></a>
                    </div>
                    <div class="esd-delete" title="Delete" disabled="disabled">
                        <a><span class="es-icon-delete"></span></a>
                    </div>
                </div> 
               <table width="100%" cellspacing="0" cellpadding="0"> 
                <tbody class="ui-droppable"> 
                 <tr class="ui-draggable"> 
                  <td class="esd-container-frame esd-frame esdev-disable-select esd-hover" width="530" valign="top" align="center" esd-handler-name="containerHandler">
            <div class="esd-structure-type">
        
            </div><div class="esd-block-btn ">
                    <div class="esd-more"><a><span class="es-icon-dot-3"></span></a></div>
                    
            <div class="esd-save" title="Save as module">
                <a><span class="es-icon-save"></span></a></div>
                    
                    <div class="esd-move ui-draggable-handle" title="Move">
                        <a><span class="es-icon-move"></span></a>
                    </div>
                    <div class="esd-copy ui-draggable-handle" title="Copy">
                        <a><span class="es-icon-copy"></span></a>
                    </div>
                    <div class="esd-delete" title="Delete">
                        <a><span class="es-icon-delete"></span></a>
                    </div>
                </div> 
                   <table width="100%" cellspacing="0" cellpadding="0"> 
                    <tbody class="ui-droppable"> 
                      
                      
                     <tr class="ui-draggable"> 
                      <td esdev-links-color="#777777" align="left" class="esd-block-text es-m-txt-c es-p5b esd-frame esd-draggable esd-block esd-hover esdev-disable-select" esd-handler-name="textElementHandler" contenteditable="true"><div class="esd-block-btn " contenteditable="false">
                    <div class="esd-more"><a><span class="es-icon-dot-3"></span></a></div>
                    
                    
                    <div class="esd-move ui-draggable-handle" title="Move">
                        <a><span class="es-icon-move"></span></a>
                    </div>
                    <div class="esd-copy ui-draggable-handle" title="Copy">
                        <a><span class="es-icon-copy"></span></a>
                    </div>
                    <div class="esd-delete" title="Delete">
                        <a><span class="es-icon-delete"></span></a>
                    </div>
                </div><p style="color: #777777; font-size: 12px;">Vous recevez ce mail car un administrateur de l\'application '. $_ENV['FRONT_URL'] .' a renseigné votre adresse à la création d\'un nouvel utilisateur.</p></td> 
                     </tr> 
                    </tbody> 
                   </table></td> 
                 </tr> 
                </tbody> 
               </table></td> 
             </tr> 
            </tbody> 
           </table></td> 
         </tr> 
        </tbody> 
       </table> 
       </td> 
     </tr> 
    </tbody> 
   </table> 
  </div>  
 </body></html>
        ';
    }

    /**
     * @param array $data
     * 
     * @return string
     */
    public function getForgotPassword(array $data): string {
        return '
        <html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office"><head> 
  <meta charset="UTF-8"> 
  <meta content="width=device-width, initial-scale=1" name="viewport"> 
  <meta name="x-apple-disable-message-reformatting"> 
  <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
  <meta content="telephone=no" name="format-detection"> 
  <title></title> 
  <!--[if (mso 16)]>
    <style type="text/css">
    a {text-decoration: none;}
    </style>
    <![endif]--> 
  <!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]--> 
  <!--[if !mso]><!-- --> 
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i" rel="stylesheet"> 
  <!--<![endif]--> 
  <!--[if gte mso 9]>
<xml>
    <o:OfficeDocumentSettings>
    <o:AllowPNG></o:AllowPNG>
    <o:PixelsPerInch>96</o:PixelsPerInch>
    </o:OfficeDocumentSettings>
</xml>
<![endif]--> 
 <link rel="stylesheet" type="text/css" href="https://my.stripo.email/static/assets/css/minimalist/editor.css?t=F61A"><link href="https://fonts.googleapis.com/css?family=Arvo:400,400i,700,700i|Lato:400,400i,700,700i|Lora:400,400i,700,700i|Merriweather:400,400i,700,700i|Merriweather Sans:400,400i,700,700i|Noticia Text:400,400i,700,700i|Open Sans:400,400i,700,700i|Playfair Display:400,400i,700,700i|Roboto:400,400i,700,700i|Source Sans Pro:400,400i,700,700i" rel="stylesheet"><link href="https://my.stripo.email/static/assets/css/dev-custom-scroll.css" rel="stylesheet"><link href="https://my.stripo.email/static/assets/fonts/banner/fonts.css" rel="stylesheet"><link href="https://my.stripo.email/static/assets/css/jquery-ui.css" rel="stylesheet" type="text/css"><meta http-equiv="Content-Security-Policy" content="script-src \'self\' https://cdn-ckeditor.stripo.email https://staging.stripo.email https://plugins.stripo.email https://green.stripo.email https://stripo.email https://vimeo.com https://stripo-app.firebaseio.com https://stripo-app.firebaseapp.com  \'unsafe-eval\'; connect-src \'none\'; object-src \'none\'; form-action \'none\';"><link rel="stylesheet" href="https://my.stripo.email/static/assets/css/dev-preview-styles.css" class="esdev-internal-css"><link rel="stylesheet" href="https://my.stripo.email/static/assets/css/dev-preview-styles.css" class="esdev-internal-css"><style class="esdev-css">/* CONFIG STYLES Please do not delete and edit CSS styles below */
/* IMPORTANT THIS STYLES MUST BE ON FINAL EMAIL */
#outlook a {
	padding: 0;
}
.ExternalClass {
	width: 100%;
}
.ExternalClass,
.ExternalClass p,
.ExternalClass span,
.ExternalClass font,
.ExternalClass td,
.ExternalClass div {
	line-height: 100%;
}
.es-button {
	mso-style-priority: 100 !important;
	text-decoration: none !important;
}
a[x-apple-data-detectors] {
	color: inherit !important;
	text-decoration: none !important;
	font-size: inherit !important;
	font-family: inherit !important;
	font-weight: inherit !important;
	line-height: inherit !important;
}
.es-desk-hidden {
	display: none;
	float: left;
	overflow: hidden;
	width: 0;
	max-height: 0;
	line-height: 0;
	mso-hide: all;
}
[data-ogsb] .es-button {
	border-width: 0 !important;
	padding: 15px 30px 15px 30px !important;
}
[data-ogsb] .es-button.es-button-1629968913941 {
	padding: 15px 30px !important;
}
/*
END OF IMPORTANT
*/
s {
	text-decoration: line-through;
}
html,
body {
	width: 100%;
	font-family: \'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;
	-webkit-text-size-adjust: 100%;
	-ms-text-size-adjust: 100%;
}
table {
	mso-table-lspace: 0pt;
	mso-table-rspace: 0pt;
	border-collapse: collapse;
	border-spacing: 0px;
}
table td,
html,
body,
.es-wrapper {
	padding: 0;
	Margin: 0;
}
.es-content,
.es-header,
.es-footer {
	table-layout: fixed !important;
	width: 100%;
}
img {
	display: block;
	border: 0;
	outline: none;
	text-decoration: none;
	-ms-interpolation-mode: bicubic;
}
table tr {
	border-collapse: collapse;
}
p,
hr {
	Margin: 0;
}
h1,
h2,
h3,
h4,
h5 {
	Margin: 0;
	line-height: 120%;
	mso-line-height-rule: exactly;
	font-family: \'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;
}
p,
ul li,
ol li,
a {
	-webkit-text-size-adjust: none;
	-ms-text-size-adjust: none;
	mso-line-height-rule: exactly;
}
.es-left {
	float: left;
}
.es-right {
	float: right;
}
.es-p5 {
	padding: 5px;
}
.es-p5t {
	padding-top: 5px;
}
.es-p5b {
	padding-bottom: 5px;
}
.es-p5l {
	padding-left: 5px;
}
.es-p5r {
	padding-right: 5px;
}
.es-p10 {
	padding: 10px;
}
.es-p10t {
	padding-top: 10px;
}
.es-p10b {
	padding-bottom: 10px;
}
.es-p10l {
	padding-left: 10px;
}
.es-p10r {
	padding-right: 10px;
}
.es-p15 {
	padding: 15px;
}
.es-p15t {
	padding-top: 15px;
}
.es-p15b {
	padding-bottom: 15px;
}
.es-p15l {
	padding-left: 15px;
}
.es-p15r {
	padding-right: 15px;
}
.es-p20 {
	padding: 20px;
}
.es-p20t {
	padding-top: 20px;
}
.es-p20b {
	padding-bottom: 20px;
}
.es-p20l {
	padding-left: 20px;
}
.es-p20r {
	padding-right: 20px;
}
.es-p25 {
	padding: 25px;
}
.es-p25t {
	padding-top: 25px;
}
.es-p25b {
	padding-bottom: 25px;
}
.es-p25l {
	padding-left: 25px;
}
.es-p25r {
	padding-right: 25px;
}
.es-p30 {
	padding: 30px;
}
.es-p30t {
	padding-top: 30px;
}
.es-p30b {
	padding-bottom: 30px;
}
.es-p30l {
	padding-left: 30px;
}
.es-p30r {
	padding-right: 30px;
}
.es-p35 {
	padding: 35px;
}
.es-p35t {
	padding-top: 35px;
}
.es-p35b {
	padding-bottom: 35px;
}
.es-p35l {
	padding-left: 35px;
}
.es-p35r {
	padding-right: 35px;
}
.es-p40 {
	padding: 40px;
}
.es-p40t {
	padding-top: 40px;
}
.es-p40b {
	padding-bottom: 40px;
}
.es-p40l {
	padding-left: 40px;
}
.es-p40r {
	padding-right: 40px;
}
.es-menu td {
	border: 0;
}
.es-menu td a img {
	display: inline-block !important;
}
/* END CONFIG STYLES */
a {
	text-decoration: none;
}
p,
ul li,
ol li {
	font-family: \'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;
	line-height: 150%;
}
ul li,
ol li {
	Margin-bottom: 15px;
}
.es-menu td a {
	text-decoration: none;
	display: block;
	font-family: \'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;
}
.es-wrapper {
	width: 100%;
	height: 100%;
	background-image: ;
	background-repeat: repeat;
	background-position: center top;
}
.es-wrapper-color {
	background-color: #eeeeee;
}
.es-header {
	background-color: transparent;
	background-image: ;
	background-repeat: repeat;
	background-position: center top;
}
.es-header-body {
	background-color: #044767;
}
.es-header-body p,
.es-header-body ul li,
.es-header-body ol li {
	color: #ffffff;
	font-size: 14px;
}
.es-header-body a {
	color: #ffffff;
	font-size: 14px;
}
.es-content-body {
	background-color: #ffffff;
}
.es-content-body p,
.es-content-body ul li,
.es-content-body ol li {
	color: #333333;
	font-size: 15px;
}
.es-content-body a {
	color: #ed8e20;
	font-size: 15px;
}
.es-footer {
	background-color: transparent;
	background-image: ;
	background-repeat: repeat;
	background-position: center top;
}
.es-footer-body {
	background-color: #ffffff;
}
.es-footer-body p,
.es-footer-body ul li,
.es-footer-body ol li {
	color: #333333;
	font-size: 14px;
}
.es-footer-body a {
	color: #333333;
	font-size: 14px;
}
.es-infoblock,
.es-infoblock p,
.es-infoblock ul li,
.es-infoblock ol li {
	line-height: 120%;
	font-size: 12px;
	color: #cccccc;
}
.es-infoblock a {
	font-size: 12px;
	color: #cccccc;
}
h1 {
	font-size: 36px;
	font-style: normal;
	font-weight: bold;
	color: #333333;
}
h2 {
	font-size: 30px;
	font-style: normal;
	font-weight: bold;
	color: #333333;
}
h3 {
	font-size: 20px;
	font-style: normal;
	font-weight: bold;
	color: #333333;
}
.es-header-body h1 a,.es-content-body h1 a,.es-footer-body h1 a {
	font-size: 36px;
}
.es-header-body h2 a,.es-content-body h2 a,.es-footer-body h2 a {
	font-size: 30px;
}
.es-header-body h3 a,.es-content-body h3 a,.es-footer-body h3 a {
	font-size: 20px;
}
a.es-button, button.es-button {
	border-style: solid;
	border-color: #ed8e20;
	border-width: 15px 30px 15px 30px;
	display: inline-block;
	background: #ed8e20;
	border-radius: 5px;
	font-size: 16px;
	font-family: \'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;
	font-weight: bold;
	font-style: normal;
	line-height: 120%;
	color: #ffffff;
	text-decoration: none;
	width: auto;
	text-align: center;
}
.es-button-border {
	border-style: solid solid solid solid;
	border-color: transparent transparent transparent transparent;
	background: #ed8e20;
	border-width: 0px 0px 0px 0px;
	display: inline-block;
	border-radius: 5px;
	width: auto;
}
/* RESPONSIVE STYLES Please do not delete and edit CSS styles below. If you don\'t need responsive layout, please delete this section. */
@media only screen and (max-width: 600px) {
	p,
    ul li,
    ol li,
    a {
		line-height: 150% !important;
	}
	h1,h2,h3,h1 a,h2 a,h3 a {
		line-height: 120% !important;
	}
	h1 {
		font-size: 32px !important;
		text-align: center;
	}
	h2 {
		font-size: 26px !important;
		text-align: center;
	}
	h3 {
		font-size: 20px !important;
		text-align: center;
	}
	.es-header-body h1 a,.es-content-body h1 a,.es-footer-body h1 a {
		font-size: 32px !important;
	}
	.es-header-body h2 a,.es-content-body h2 a,.es-footer-body h2 a {
		font-size: 26px !important;
	}
	.es-header-body h3 a,.es-content-body h3 a,.es-footer-body h3 a {
		font-size: 20px !important;
	}
	.es-menu td a {
		font-size: 16px !important;
	}
	.es-header-body p,
    .es-header-body ul li,
    .es-header-body ol li,
    .es-header-body a {
		font-size: 16px !important;
	}
	.es-content-body p,.es-content-body ul li,.es-content-body ol li,.es-content-body a {
		font-size: 16px !important;
	}
	.es-footer-body p,
    .es-footer-body ul li,
    .es-footer-body ol li,
    .es-footer-body a {
		font-size: 16px !important;
	}
	.es-infoblock p,
    .es-infoblock ul li,
    .es-infoblock ol li,
    .es-infoblock a {
		font-size: 12px !important;
	}
	*[class="gmail-fix"] {
		display: none !important;
	}
	.es-m-txt-c,
    .es-m-txt-c h1,
    .es-m-txt-c h2,
    .es-m-txt-c h3 {
		text-align: center !important;
	}
	.es-m-txt-r,
    .es-m-txt-r h1,
    .es-m-txt-r h2,
    .es-m-txt-r h3 {
		text-align: right !important;
	}
	.es-m-txt-l,
    .es-m-txt-l h1,
    .es-m-txt-l h2,
    .es-m-txt-l h3 {
		text-align: left !important;
	}
	.es-m-txt-r img,
    .es-m-txt-c img,
    .es-m-txt-l img {
		display: inline !important;
	}
	.es-button-border {
		display: inline-block !important;
	}
	a.es-button, button.es-button {
		font-size: 16px !important;
		display: inline-block !important;
		border-width: 15px 30px 15px 30px !important;
	}
	.es-btn-fw {
		border-width: 10px 0px !important;
		text-align: center !important;
	}
	.es-adaptive table,
    .es-btn-fw,
    .es-btn-fw-brdr,
    .es-left,
    .es-right {
		width: 100% !important;
	}
	.es-content table,
    .es-header table,
    .es-footer table,
    .es-content,
    .es-footer,
    .es-header {
		width: 100% !important;
		max-width: 600px !important;
	}
	.es-adapt-td {
		display: block !important;
		width: 100% !important;
	}
	.adapt-img {
		width: 100% !important;
		height: auto !important;
	}
	.es-m-p0 {
		padding: 0px !important;
	}
	.es-m-p0r {
		padding-right: 0px !important;
	}
	.es-m-p0l {
		padding-left: 0px !important;
	}
	.es-m-p0t {
		padding-top: 0px !important;
	}
	.es-m-p0b {
		padding-bottom: 0 !important;
	}
	.es-m-p20b {
		padding-bottom: 20px !important;
	}
	.es-mobile-hidden,
    .es-hidden {
		display: none !important;
	}
	tr.es-desk-hidden,
    td.es-desk-hidden,
    table.es-desk-hidden {
		width: auto!important;
		overflow: visible!important;
		float: none!important;
		max-height: inherit!important;
		line-height: inherit!important;
	}
	tr.es-desk-hidden {
		display: table-row !important;
	}
	table.es-desk-hidden {
		display: table !important;
	}
	td.es-desk-menu-hidden {
		display: table-cell!important;
	}
	.es-menu td {
		width: 1% !important;
	}
	table.es-table-not-adapt,
    .esd-block-html table {
		width: auto !important;
	}
	table.es-social {
		display: inline-block !important;
	}
	table.es-social td {
		display: inline-block !important;
	}
}
/* END RESPONSIVE STYLES */
.es-p-default {
	padding-top: 20px;
	padding-right: 35px;
	padding-bottom: 0px;
	padding-left: 35px;
}
.es-p-all-default {
	padding: 0px;
}
</style></head><body class=""> 
  <div class="es-wrapper-color"> 
   <!--[if gte mso 9]>
			<v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
				<v:fill type="tile" color="#eeeeee"></v:fill>
			</v:background>
		<![endif]--> 
   <table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0"> 
    <tbody> 
     <tr> 
      <td class="esd-email-paddings ui-droppable" valign="top"> 
        
        
       <table class="es-content ui-draggable" cellspacing="0" cellpadding="0" align="center"> 
        <tbody> 
         <tr> 
          <td class="esd-stripe esd-frame esdev-disable-select esd-hover" align="center" esd-handler-name="stripeBlockHandler">
            <div class="esd-structure-type">
        
            </div><div class="esd-block-btn">
                    <div class="esd-more"><a><span class="es-icon-dot-3"></span></a></div>
                    
            <div class="esd-save" title="Save as module">
                <a><span class="es-icon-save"></span></a></div>
                    
                    <div class="esd-move ui-draggable-handle" title="Move">
                        <a><span class="es-icon-move"></span></a>
                    </div>
                    <div class="esd-copy ui-draggable-handle" title="Copy">
                        <a><span class="es-icon-copy"></span></a>
                    </div>
                    <div class="esd-delete" title="Delete">
                        <a><span class="es-icon-delete"></span></a>
                    </div>
                </div>
            <div class="esd-add-stripe">
                <a><span class="es-icon-plus"></span></a>
                <div class="esd-stripes-popover esd-hidden-right">
                    <div class="esd-popover-content">
                        
                                <div class="esd-stripe-preview" esd-element-name="structureType_100">
                                    
            <div class="col-xs-12">
                <a class="esd-structure-preview"></a>
            </div>
                                </div>
                                <div class="esd-stripe-preview" esd-element-name="structureType_50_50">
                                    
            <div class="col-xs-6">
                <a class="esd-structure-preview"></a>
            </div>
            <div class="col-xs-6">
                <a class="esd-structure-preview"></a>
            </div>
                                </div>
                                <div class="esd-stripe-preview" esd-element-name="structureType_33_33_33">
                                    
            <div class="col-xs-4">
                <a class="esd-structure-preview"></a>
            </div>
            <div class="col-xs-4">
                <a class="esd-structure-preview"></a>
            </div>
            <div class="col-xs-4">
                <a class="esd-structure-preview"></a>
            </div>
                                </div>
                                <div class="esd-stripe-preview" esd-element-name="structureType_25_25_25_25">
                                    
            <div class="col-xs-3">
                <a class="esd-structure-preview"></a>
            </div>
            <div class="col-xs-3">
                <a class="esd-structure-preview"></a>
            </div>
            <div class="col-xs-3">
                <a class="esd-structure-preview"></a>
            </div>
            <div class="col-xs-3">
                <a class="esd-structure-preview"></a>
            </div>
                                </div>
                                <div class="esd-stripe-preview" esd-element-name="structureType_33_66">
                                    
            <div class="col-xs-4">
                <a class="esd-structure-preview"></a>
            </div>
            <div class="col-xs-8">
                <a class="esd-structure-preview"></a>
            </div>
                                </div>
                                <div class="esd-stripe-preview" esd-element-name="structureType_66_33">
                                    
            <div class="col-xs-8">
                <a class="esd-structure-preview"></a>
            </div>
            <div class="col-xs-4">
                <a class="esd-structure-preview"></a>
            </div>
                                </div>
                    </div>
                </div>
            </div>
         
           <table class="es-content-body" width="600" cellspacing="0" cellpadding="0" align="center" esd-img-prev-src="" style="background-color: transparent;"> 
            <tbody class="ui-droppable"> 
             <tr class="ui-draggable"> 
              <td class="esd-structure es-p40t es-p35b es-p35r es-p35l esd-frame esdev-disable-select" style="background-color: rgb(247, 247, 247);" bgcolor="#f7f7f7" align="left" esd-handler-name="structureBlockHandler">
            <div class="esd-structure-type">
        
            </div><div class="esd-block-btn ">
                    <div class="esd-more"><a><span class="es-icon-dot-3"></span></a></div>
                    
            <div class="esd-save" title="Save as module">
                <a><span class="es-icon-save"></span></a></div>
                    
                    <div class="esd-move ui-draggable-handle" title="Move">
                        <a><span class="es-icon-move"></span></a>
                    </div>
                    <div class="esd-copy ui-draggable-handle" title="Copy">
                        <a><span class="es-icon-copy"></span></a>
                    </div>
                    <div class="esd-delete" title="Delete" disabled="disabled">
                        <a><span class="es-icon-delete"></span></a>
                    </div>
                </div> 
               <table width="100%" cellspacing="0" cellpadding="0"> 
                <tbody class="ui-droppable"> 
                 <tr class="ui-draggable"> 
                  <td class="esd-container-frame esd-frame esdev-disable-select esd-hover" width="530" valign="top" align="center" esd-handler-name="containerHandler">
            <div class="esd-structure-type">
        
            </div><div class="esd-block-btn">
                    <div class="esd-more"><a><span class="es-icon-dot-3"></span></a></div>
                    
            <div class="esd-save" title="Save as module">
                <a><span class="es-icon-save"></span></a></div>
                    
                    <div class="esd-move ui-draggable-handle" title="Move">
                        <a><span class="es-icon-move"></span></a>
                    </div>
                    <div class="esd-copy ui-draggable-handle" title="Copy">
                        <a><span class="es-icon-copy"></span></a>
                    </div>
                    <div class="esd-delete" title="Delete">
                        <a><span class="es-icon-delete"></span></a>
                    </div>
                </div> 
                   <table width="100%" cellspacing="0" cellpadding="0"> 
                    <tbody class="ui-droppable"> 
                     <tr class="ui-draggable"> 
                      <td class="esd-block-image es-p20t es-p25b es-p35r es-p35l esd-frame esdev-disable-select esd-draggable esd-block esd-hover" align="center" style="font-size: 0px;" esd-handler-name="imgBlockHandler"><div class="esd-block-btn">
                    <div class="esd-more"><a><span class="es-icon-dot-3"></span></a></div>
                    
                    
                    <div class="esd-move ui-draggable-handle" title="Move">
                        <a><span class="es-icon-move"></span></a>
                    </div>
                    <div class="esd-copy ui-draggable-handle" title="Copy">
                        <a><span class="es-icon-copy"></span></a>
                    </div>
                    <div class="esd-delete" title="Delete">
                        <a><span class="es-icon-delete"></span></a>
                    </div>

                </div>
<img src="https://www.carasante.com/wp-content/uploads/2021/04/logocarasante-e1450701241142.png" alt="ship" style="display: block;" title="ship" width="150">
</td> 
                     </tr> 
                     <tr class="ui-draggable"> 
                      <td class="esd-block-text es-p15b esd-frame esd-draggable esd-block esd-hover esdev-disable-select" align="center" esd-handler-name="textElementHandler" contenteditable="true"><div class="esd-block-btn" contenteditable="false">
                    <div class="esd-more"><a><span class="es-icon-dot-3"></span></a></div>
                    
                    
                    <div class="esd-move ui-draggable-handle" title="Move">
                        <a><span class="es-icon-move"></span></a>
                    </div>
                    <div class="esd-copy ui-draggable-handle" title="Copy">
                        <a><span class="es-icon-copy"></span></a>
                    </div>
                    <div class="esd-delete" title="Delete">
                        <a><span class="es-icon-delete"></span></a>
                    </div>
                </div><h2 style="color: #333333; font-family: \'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;">'. $data['firstName'] .', rénitialisez votre mot de passe !</h2></td> 
                     </tr> 
                     <tr class="ui-draggable"> 
                      <td class="esd-block-text es-m-txt-l es-p20t esd-frame esd-draggable esd-block esd-hover esdev-disable-select" align="left" esd-handler-name="textElementHandler" contenteditable="true"><div class="esd-block-btn " contenteditable="false">
                    <div class="esd-more"><a><span class="es-icon-dot-3"></span></a></div>
                    
                    
                    <div class="esd-move ui-draggable-handle" title="Move">
                        <a><span class="es-icon-move"></span></a>
                    </div>
                    <div class="esd-copy ui-draggable-handle" title="Copy">
                        <a><span class="es-icon-copy"></span></a>
                    </div>
                    <div class="esd-delete" title="Delete">
                        <a><span class="es-icon-delete"></span></a>
                    </div>
                </div><h3 style="font-size: 18px;">Une demande de changement de mot de passe à été soumise pour votre compte.</h3></td> 
                     </tr> 
                     <tr class="ui-draggable"> 
                      <td class="esd-block-text es-p15t es-p10b esd-frame esd-draggable esd-block esd-hover esdev-disable-select" align="left" esd-handler-name="textElementHandler" contenteditable="true"><div class="esd-block-btn" contenteditable="false">
                    <div class="esd-more"><a><span class="es-icon-dot-3"></span></a></div>
                    
                    
                    <div class="esd-move ui-draggable-handle" title="Move">
                        <a><span class="es-icon-move"></span></a>
                    </div>
                    <div class="esd-copy ui-draggable-handle" title="Copy">
                        <a><span class="es-icon-copy"></span></a>
                    </div>
                    <div class="esd-delete" title="Delete">
                        <a><span class="es-icon-delete"></span></a>
                    </div>
                </div><p style="font-size: 16px; color: #777777;">Cliquez sur le bouton ci-dessous pour procéder au changement, ignorez ce mail si vous n\'est pas à l\'origine de cette demande.<br></p></td> 
                     </tr> 
                     <tr class="ui-draggable"> 
                      <td class="esd-block-button es-p25t es-p20b es-p10r es-p10l esd-frame esdev-disable-select esd-draggable esd-block esd-hover" align="center" esd-handler-name="btnBlockHandler"><div class="esd-block-btn">
                    <div class="esd-more"><a><span class="es-icon-dot-3"></span></a></div>
                    
                    
                    <div class="esd-move ui-draggable-handle" title="Move">
                        <a><span class="es-icon-move"></span></a>
                    </div>
                    <div class="esd-copy ui-draggable-handle" title="Copy">
                        <a><span class="es-icon-copy"></span></a>
                    </div>
                    <div class="esd-delete" title="Delete">
                        <a><span class="es-icon-delete"></span></a>
                    </div>
                </div><span class="es-button-border" style="background-color: rgb(0 184 221);"><a href="'. $_ENV['FRONT_URL'] . '/set-password/' . $data['token'] .'" class="es-button es-button-1629968913941" target="_blank" style="font-weight: normal; border-width: 15px 30px; color: rgb(255, 255, 255); font-size: 18px; background-color: rgb(0 184 221); border-color: rgb(0 184 221);">Changer mon mot de passe</a></span></td> 
                     </tr> 
                    </tbody> 
                   </table></td> 
                 </tr> 
                </tbody> 
               </table></td> 
             </tr> 
              
            </tbody> 
           </table></td> 
         </tr> 
        </tbody> 
       </table> 
        
       <table class="es-footer ui-draggable" cellspacing="0" cellpadding="0" align="center"> 
        <tbody> 
         <tr> 
          <td class="esd-stripe esd-frame esdev-disable-select esd-hover" align="center" esd-handler-name="stripeBlockHandler">
            <div class="esd-structure-type">
        
            </div><div class="esd-block-btn">
                    <div class="esd-more"><a><span class="es-icon-dot-3"></span></a></div>
                    
            <div class="esd-save" title="Save as module">
                <a><span class="es-icon-save"></span></a></div>
                    
                    <div class="esd-move ui-draggable-handle" title="Move">
                        <a><span class="es-icon-move"></span></a>
                    </div>
                    <div class="esd-copy ui-draggable-handle" title="Copy">
                        <a><span class="es-icon-copy"></span></a>
                    </div>
                    <div class="esd-delete" title="Delete">
                        <a><span class="es-icon-delete"></span></a>
                    </div>
                </div>
            <div class="esd-add-stripe">
                <a><span class="es-icon-plus"></span></a>
                <div class="esd-stripes-popover esd-hidden-right">
                    <div class="esd-popover-content">
                        
                                <div class="esd-stripe-preview" esd-element-name="structureType_100">
                                    
            <div class="col-xs-12">
                <a class="esd-structure-preview"></a>
            </div>
                                </div>
                                <div class="esd-stripe-preview" esd-element-name="structureType_50_50">
                                    
            <div class="col-xs-6">
                <a class="esd-structure-preview"></a>
            </div>
            <div class="col-xs-6">
                <a class="esd-structure-preview"></a>
            </div>
                                </div>
                                <div class="esd-stripe-preview" esd-element-name="structureType_33_33_33">
                                    
            <div class="col-xs-4">
                <a class="esd-structure-preview"></a>
            </div>
            <div class="col-xs-4">
                <a class="esd-structure-preview"></a>
            </div>
            <div class="col-xs-4">
                <a class="esd-structure-preview"></a>
            </div>
                                </div>
                                <div class="esd-stripe-preview" esd-element-name="structureType_25_25_25_25">
                                    
            <div class="col-xs-3">
                <a class="esd-structure-preview"></a>
            </div>
            <div class="col-xs-3">
                <a class="esd-structure-preview"></a>
            </div>
            <div class="col-xs-3">
                <a class="esd-structure-preview"></a>
            </div>
            <div class="col-xs-3">
                <a class="esd-structure-preview"></a>
            </div>
                                </div>
                                <div class="esd-stripe-preview" esd-element-name="structureType_33_66">
                                    
            <div class="col-xs-4">
                <a class="esd-structure-preview"></a>
            </div>
            <div class="col-xs-8">
                <a class="esd-structure-preview"></a>
            </div>
                                </div>
                                <div class="esd-stripe-preview" esd-element-name="structureType_66_33">
                                    
            <div class="col-xs-8">
                <a class="esd-structure-preview"></a>
            </div>
            <div class="col-xs-4">
                <a class="esd-structure-preview"></a>
            </div>
                                </div>
                    </div>
                </div>
            </div>
         
           <table class="es-footer-body" width="600" cellspacing="0" cellpadding="0" align="center" esd-img-prev-src=""> 
            <tbody class="ui-droppable"> 
             <tr class="ui-draggable"> 
              <td class="esd-structure es-p35t es-p40b es-p35r es-p35l esd-frame esdev-disable-select esd-hover" align="left" esd-handler-name="structureBlockHandler">
            <div class="esd-structure-type">
        
            </div><div class="esd-block-btn">
                    <div class="esd-more"><a><span class="es-icon-dot-3"></span></a></div>
                    
            <div class="esd-save" title="Save as module">
                <a><span class="es-icon-save"></span></a></div>
                    
                    <div class="esd-move ui-draggable-handle" title="Move">
                        <a><span class="es-icon-move"></span></a>
                    </div>
                    <div class="esd-copy ui-draggable-handle" title="Copy">
                        <a><span class="es-icon-copy"></span></a>
                    </div>
                    <div class="esd-delete" title="Delete" disabled="disabled">
                        <a><span class="es-icon-delete"></span></a>
                    </div>
                </div> 
               <table width="100%" cellspacing="0" cellpadding="0"> 
                <tbody class="ui-droppable"> 
                 <tr class="ui-draggable"> 
                  <td class="esd-container-frame esd-frame esdev-disable-select esd-hover" width="530" valign="top" align="center" esd-handler-name="containerHandler">
            <div class="esd-structure-type">
        
            </div><div class="esd-block-btn ">
                    <div class="esd-more"><a><span class="es-icon-dot-3"></span></a></div>
                    
            <div class="esd-save" title="Save as module">
                <a><span class="es-icon-save"></span></a></div>
                    
                    <div class="esd-move ui-draggable-handle" title="Move">
                        <a><span class="es-icon-move"></span></a>
                    </div>
                    <div class="esd-copy ui-draggable-handle" title="Copy">
                        <a><span class="es-icon-copy"></span></a>
                    </div>
                    <div class="esd-delete" title="Delete">
                        <a><span class="es-icon-delete"></span></a>
                    </div>
                </div> 
                   <table width="100%" cellspacing="0" cellpadding="0"> 
                    <tbody class="ui-droppable"> 
                      
                      
                     <tr class="ui-draggable"> 
                      <td esdev-links-color="#777777" align="left" class="esd-block-text es-m-txt-c es-p5b esd-frame esd-draggable esd-block esd-hover esdev-disable-select" esd-handler-name="textElementHandler" contenteditable="true"><div class="esd-block-btn " contenteditable="false">
                    <div class="esd-more"><a><span class="es-icon-dot-3"></span></a></div>
                    
                    
                    <div class="esd-move ui-draggable-handle" title="Move">
                        <a><span class="es-icon-move"></span></a>
                    </div>
                    <div class="esd-copy ui-draggable-handle" title="Copy">
                        <a><span class="es-icon-copy"></span></a>
                    </div>
                    <div class="esd-delete" title="Delete">
                        <a><span class="es-icon-delete"></span></a>
                    </div>
                </div><p style="color: #777777; font-size: 12px;">Vous recevez ce mail car une demande de rénitialisation de mot de passe pour votre compte a été soumise via '. $_ENV['FRONT_URL'] .'.</p></td> 
                     </tr> 
                    </tbody> 
                   </table></td> 
                 </tr> 
                </tbody> 
               </table></td> 
             </tr> 
            </tbody> 
           </table></td> 
         </tr> 
        </tbody> 
       </table> 
       </td> 
     </tr> 
    </tbody> 
   </table> 
  </div>  
 </body></html>
        ';
    }

    /**
     * @param string $firstName
     * @param string $countSentence
     * 
     * @return string
     */
    public function getDesactivateAccount(string $firstName, string $countSentence): string {
        return '
        <html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office"><head> 
  <meta charset="UTF-8"> 
  <meta content="width=device-width, initial-scale=1" name="viewport"> 
  <meta name="x-apple-disable-message-reformatting"> 
  <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
  <meta content="telephone=no" name="format-detection"> 
  <title></title> 
  <!--[if (mso 16)]>
    <style type="text/css">
    a {text-decoration: none;}
    </style>
    <![endif]--> 
  <!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]--> 
  <!--[if !mso]><!-- --> 
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i" rel="stylesheet"> 
  <!--<![endif]--> 
  <!--[if gte mso 9]>
<xml>
    <o:OfficeDocumentSettings>
    <o:AllowPNG></o:AllowPNG>
    <o:PixelsPerInch>96</o:PixelsPerInch>
    </o:OfficeDocumentSettings>
</xml>
<![endif]--> 
 <link rel="stylesheet" type="text/css" href="https://my.stripo.email/static/assets/css/minimalist/editor.css?t=F61A"><link href="https://fonts.googleapis.com/css?family=Arvo:400,400i,700,700i|Lato:400,400i,700,700i|Lora:400,400i,700,700i|Merriweather:400,400i,700,700i|Merriweather Sans:400,400i,700,700i|Noticia Text:400,400i,700,700i|Open Sans:400,400i,700,700i|Playfair Display:400,400i,700,700i|Roboto:400,400i,700,700i|Source Sans Pro:400,400i,700,700i" rel="stylesheet"><link href="https://my.stripo.email/static/assets/css/dev-custom-scroll.css" rel="stylesheet"><link href="https://my.stripo.email/static/assets/fonts/banner/fonts.css" rel="stylesheet"><link href="https://my.stripo.email/static/assets/css/jquery-ui.css" rel="stylesheet" type="text/css"><meta http-equiv="Content-Security-Policy" content="script-src \'self\' https://cdn-ckeditor.stripo.email https://staging.stripo.email https://plugins.stripo.email https://green.stripo.email https://stripo.email https://vimeo.com https://stripo-app.firebaseio.com https://stripo-app.firebaseapp.com  \'unsafe-eval\'; connect-src \'none\'; object-src \'none\'; form-action \'none\';"><link rel="stylesheet" href="https://my.stripo.email/static/assets/css/dev-preview-styles.css" class="esdev-internal-css"><link rel="stylesheet" href="https://my.stripo.email/static/assets/css/dev-preview-styles.css" class="esdev-internal-css"><style class="esdev-css">/* CONFIG STYLES Please do not delete and edit CSS styles below */
/* IMPORTANT THIS STYLES MUST BE ON FINAL EMAIL */
#outlook a {
	padding: 0;
}
.ExternalClass {
	width: 100%;
}
.ExternalClass,
.ExternalClass p,
.ExternalClass span,
.ExternalClass font,
.ExternalClass td,
.ExternalClass div {
	line-height: 100%;
}
.es-button {
	mso-style-priority: 100 !important;
	text-decoration: none !important;
}
a[x-apple-data-detectors] {
	color: inherit !important;
	text-decoration: none !important;
	font-size: inherit !important;
	font-family: inherit !important;
	font-weight: inherit !important;
	line-height: inherit !important;
}
.es-desk-hidden {
	display: none;
	float: left;
	overflow: hidden;
	width: 0;
	max-height: 0;
	line-height: 0;
	mso-hide: all;
}
[data-ogsb] .es-button {
	border-width: 0 !important;
	padding: 15px 30px 15px 30px !important;
}
[data-ogsb] .es-button.es-button-1629968913941 {
	padding: 15px 30px !important;
}
/*
END OF IMPORTANT
*/
s {
	text-decoration: line-through;
}
html,
body {
	width: 100%;
	font-family: \'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;
	-webkit-text-size-adjust: 100%;
	-ms-text-size-adjust: 100%;
}
table {
	mso-table-lspace: 0pt;
	mso-table-rspace: 0pt;
	border-collapse: collapse;
	border-spacing: 0px;
}
table td,
html,
body,
.es-wrapper {
	padding: 0;
	Margin: 0;
}
.es-content,
.es-header,
.es-footer {
	table-layout: fixed !important;
	width: 100%;
}
img {
	display: block;
	border: 0;
	outline: none;
	text-decoration: none;
	-ms-interpolation-mode: bicubic;
}
table tr {
	border-collapse: collapse;
}
p,
hr {
	Margin: 0;
}
h1,
h2,
h3,
h4,
h5 {
	Margin: 0;
	line-height: 120%;
	mso-line-height-rule: exactly;
	font-family: \'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;
}
p,
ul li,
ol li,
a {
	-webkit-text-size-adjust: none;
	-ms-text-size-adjust: none;
	mso-line-height-rule: exactly;
}
.es-left {
	float: left;
}
.es-right {
	float: right;
}
.es-p5 {
	padding: 5px;
}
.es-p5t {
	padding-top: 5px;
}
.es-p5b {
	padding-bottom: 5px;
}
.es-p5l {
	padding-left: 5px;
}
.es-p5r {
	padding-right: 5px;
}
.es-p10 {
	padding: 10px;
}
.es-p10t {
	padding-top: 10px;
}
.es-p10b {
	padding-bottom: 10px;
}
.es-p10l {
	padding-left: 10px;
}
.es-p10r {
	padding-right: 10px;
}
.es-p15 {
	padding: 15px;
}
.es-p15t {
	padding-top: 15px;
}
.es-p15b {
	padding-bottom: 15px;
}
.es-p15l {
	padding-left: 15px;
}
.es-p15r {
	padding-right: 15px;
}
.es-p20 {
	padding: 20px;
}
.es-p20t {
	padding-top: 20px;
}
.es-p20b {
	padding-bottom: 20px;
}
.es-p20l {
	padding-left: 20px;
}
.es-p20r {
	padding-right: 20px;
}
.es-p25 {
	padding: 25px;
}
.es-p25t {
	padding-top: 25px;
}
.es-p25b {
	padding-bottom: 25px;
}
.es-p25l {
	padding-left: 25px;
}
.es-p25r {
	padding-right: 25px;
}
.es-p30 {
	padding: 30px;
}
.es-p30t {
	padding-top: 30px;
}
.es-p30b {
	padding-bottom: 30px;
}
.es-p30l {
	padding-left: 30px;
}
.es-p30r {
	padding-right: 30px;
}
.es-p35 {
	padding: 35px;
}
.es-p35t {
	padding-top: 35px;
}
.es-p35b {
	padding-bottom: 35px;
}
.es-p35l {
	padding-left: 35px;
}
.es-p35r {
	padding-right: 35px;
}
.es-p40 {
	padding: 40px;
}
.es-p40t {
	padding-top: 40px;
}
.es-p40b {
	padding-bottom: 40px;
}
.es-p40l {
	padding-left: 40px;
}
.es-p40r {
	padding-right: 40px;
}
.es-menu td {
	border: 0;
}
.es-menu td a img {
	display: inline-block !important;
}
/* END CONFIG STYLES */
a {
	text-decoration: none;
}
p,
ul li,
ol li {
	font-family: \'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;
	line-height: 150%;
}
ul li,
ol li {
	Margin-bottom: 15px;
}
.es-menu td a {
	text-decoration: none;
	display: block;
	font-family: \'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;
}
.es-wrapper {
	width: 100%;
	height: 100%;
	background-image: ;
	background-repeat: repeat;
	background-position: center top;
}
.es-wrapper-color {
	background-color: #eeeeee;
}
.es-header {
	background-color: transparent;
	background-image: ;
	background-repeat: repeat;
	background-position: center top;
}
.es-header-body {
	background-color: #044767;
}
.es-header-body p,
.es-header-body ul li,
.es-header-body ol li {
	color: #ffffff;
	font-size: 14px;
}
.es-header-body a {
	color: #ffffff;
	font-size: 14px;
}
.es-content-body {
	background-color: #ffffff;
}
.es-content-body p,
.es-content-body ul li,
.es-content-body ol li {
	color: #333333;
	font-size: 15px;
}
.es-content-body a {
	color: #ed8e20;
	font-size: 15px;
}
.es-footer {
	background-color: transparent;
	background-image: ;
	background-repeat: repeat;
	background-position: center top;
}
.es-footer-body {
	background-color: #ffffff;
}
.es-footer-body p,
.es-footer-body ul li,
.es-footer-body ol li {
	color: #333333;
	font-size: 14px;
}
.es-footer-body a {
	color: #333333;
	font-size: 14px;
}
.es-infoblock,
.es-infoblock p,
.es-infoblock ul li,
.es-infoblock ol li {
	line-height: 120%;
	font-size: 12px;
	color: #cccccc;
}
.es-infoblock a {
	font-size: 12px;
	color: #cccccc;
}
h1 {
	font-size: 36px;
	font-style: normal;
	font-weight: bold;
	color: #333333;
}
h2 {
	font-size: 30px;
	font-style: normal;
	font-weight: bold;
	color: #333333;
}
h3 {
	font-size: 20px;
	font-style: normal;
	font-weight: bold;
	color: #333333;
}
.es-header-body h1 a,.es-content-body h1 a,.es-footer-body h1 a {
	font-size: 36px;
}
.es-header-body h2 a,.es-content-body h2 a,.es-footer-body h2 a {
	font-size: 30px;
}
.es-header-body h3 a,.es-content-body h3 a,.es-footer-body h3 a {
	font-size: 20px;
}
a.es-button, button.es-button {
	border-style: solid;
	border-color: #ed8e20;
	border-width: 15px 30px 15px 30px;
	display: inline-block;
	background: #ed8e20;
	border-radius: 5px;
	font-size: 16px;
	font-family: \'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;
	font-weight: bold;
	font-style: normal;
	line-height: 120%;
	color: #ffffff;
	text-decoration: none;
	width: auto;
	text-align: center;
}
.es-button-border {
	border-style: solid solid solid solid;
	border-color: transparent transparent transparent transparent;
	background: #ed8e20;
	border-width: 0px 0px 0px 0px;
	display: inline-block;
	border-radius: 5px;
	width: auto;
}
/* RESPONSIVE STYLES Please do not delete and edit CSS styles below. If you don\'t need responsive layout, please delete this section. */
@media only screen and (max-width: 600px) {
	p,
    ul li,
    ol li,
    a {
		line-height: 150% !important;
	}
	h1,h2,h3,h1 a,h2 a,h3 a {
		line-height: 120% !important;
	}
	h1 {
		font-size: 32px !important;
		text-align: center;
	}
	h2 {
		font-size: 26px !important;
		text-align: center;
	}
	h3 {
		font-size: 20px !important;
		text-align: center;
	}
	.es-header-body h1 a,.es-content-body h1 a,.es-footer-body h1 a {
		font-size: 32px !important;
	}
	.es-header-body h2 a,.es-content-body h2 a,.es-footer-body h2 a {
		font-size: 26px !important;
	}
	.es-header-body h3 a,.es-content-body h3 a,.es-footer-body h3 a {
		font-size: 20px !important;
	}
	.es-menu td a {
		font-size: 16px !important;
	}
	.es-header-body p,
    .es-header-body ul li,
    .es-header-body ol li,
    .es-header-body a {
		font-size: 16px !important;
	}
	.es-content-body p,.es-content-body ul li,.es-content-body ol li,.es-content-body a {
		font-size: 16px !important;
	}
	.es-footer-body p,
    .es-footer-body ul li,
    .es-footer-body ol li,
    .es-footer-body a {
		font-size: 16px !important;
	}
	.es-infoblock p,
    .es-infoblock ul li,
    .es-infoblock ol li,
    .es-infoblock a {
		font-size: 12px !important;
	}
	*[class="gmail-fix"] {
		display: none !important;
	}
	.es-m-txt-c,
    .es-m-txt-c h1,
    .es-m-txt-c h2,
    .es-m-txt-c h3 {
		text-align: center !important;
	}
	.es-m-txt-r,
    .es-m-txt-r h1,
    .es-m-txt-r h2,
    .es-m-txt-r h3 {
		text-align: right !important;
	}
	.es-m-txt-l,
    .es-m-txt-l h1,
    .es-m-txt-l h2,
    .es-m-txt-l h3 {
		text-align: left !important;
	}
	.es-m-txt-r img,
    .es-m-txt-c img,
    .es-m-txt-l img {
		display: inline !important;
	}
	.es-button-border {
		display: inline-block !important;
	}
	a.es-button, button.es-button {
		font-size: 16px !important;
		display: inline-block !important;
		border-width: 15px 30px 15px 30px !important;
	}
	.es-btn-fw {
		border-width: 10px 0px !important;
		text-align: center !important;
	}
	.es-adaptive table,
    .es-btn-fw,
    .es-btn-fw-brdr,
    .es-left,
    .es-right {
		width: 100% !important;
	}
	.es-content table,
    .es-header table,
    .es-footer table,
    .es-content,
    .es-footer,
    .es-header {
		width: 100% !important;
		max-width: 600px !important;
	}
	.es-adapt-td {
		display: block !important;
		width: 100% !important;
	}
	.adapt-img {
		width: 100% !important;
		height: auto !important;
	}
	.es-m-p0 {
		padding: 0px !important;
	}
	.es-m-p0r {
		padding-right: 0px !important;
	}
	.es-m-p0l {
		padding-left: 0px !important;
	}
	.es-m-p0t {
		padding-top: 0px !important;
	}
	.es-m-p0b {
		padding-bottom: 0 !important;
	}
	.es-m-p20b {
		padding-bottom: 20px !important;
	}
	.es-mobile-hidden,
    .es-hidden {
		display: none !important;
	}
	tr.es-desk-hidden,
    td.es-desk-hidden,
    table.es-desk-hidden {
		width: auto!important;
		overflow: visible!important;
		float: none!important;
		max-height: inherit!important;
		line-height: inherit!important;
	}
	tr.es-desk-hidden {
		display: table-row !important;
	}
	table.es-desk-hidden {
		display: table !important;
	}
	td.es-desk-menu-hidden {
		display: table-cell!important;
	}
	.es-menu td {
		width: 1% !important;
	}
	table.es-table-not-adapt,
    .esd-block-html table {
		width: auto !important;
	}
	table.es-social {
		display: inline-block !important;
	}
	table.es-social td {
		display: inline-block !important;
	}
}
/* END RESPONSIVE STYLES */
.es-p-default {
	padding-top: 20px;
	padding-right: 35px;
	padding-bottom: 0px;
	padding-left: 35px;
}
.es-p-all-default {
	padding: 0px;
}
</style></head><body class=""> 
  <div class="es-wrapper-color"> 
   <!--[if gte mso 9]>
			<v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
				<v:fill type="tile" color="#eeeeee"></v:fill>
			</v:background>
		<![endif]--> 
   <table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0"> 
    <tbody> 
     <tr> 
      <td class="esd-email-paddings ui-droppable" valign="top"> 
        
        
       <table class="es-content ui-draggable" cellspacing="0" cellpadding="0" align="center"> 
        <tbody> 
         <tr> 
          <td class="esd-stripe esd-frame esdev-disable-select esd-hover" align="center" esd-handler-name="stripeBlockHandler">
            <div class="esd-structure-type">
        
            </div><div class="esd-block-btn">
                    <div class="esd-more"><a><span class="es-icon-dot-3"></span></a></div>
                    
            <div class="esd-save" title="Save as module">
                <a><span class="es-icon-save"></span></a></div>
                    
                    <div class="esd-move ui-draggable-handle" title="Move">
                        <a><span class="es-icon-move"></span></a>
                    </div>
                    <div class="esd-copy ui-draggable-handle" title="Copy">
                        <a><span class="es-icon-copy"></span></a>
                    </div>
                    <div class="esd-delete" title="Delete">
                        <a><span class="es-icon-delete"></span></a>
                    </div>
                </div>
            <div class="esd-add-stripe">
                <a><span class="es-icon-plus"></span></a>
                <div class="esd-stripes-popover esd-hidden-right">
                    <div class="esd-popover-content">
                        
                                <div class="esd-stripe-preview" esd-element-name="structureType_100">
                                    
            <div class="col-xs-12">
                <a class="esd-structure-preview"></a>
            </div>
                                </div>
                                <div class="esd-stripe-preview" esd-element-name="structureType_50_50">
                                    
            <div class="col-xs-6">
                <a class="esd-structure-preview"></a>
            </div>
            <div class="col-xs-6">
                <a class="esd-structure-preview"></a>
            </div>
                                </div>
                                <div class="esd-stripe-preview" esd-element-name="structureType_33_33_33">
                                    
            <div class="col-xs-4">
                <a class="esd-structure-preview"></a>
            </div>
            <div class="col-xs-4">
                <a class="esd-structure-preview"></a>
            </div>
            <div class="col-xs-4">
                <a class="esd-structure-preview"></a>
            </div>
                                </div>
                                <div class="esd-stripe-preview" esd-element-name="structureType_25_25_25_25">
                                    
            <div class="col-xs-3">
                <a class="esd-structure-preview"></a>
            </div>
            <div class="col-xs-3">
                <a class="esd-structure-preview"></a>
            </div>
            <div class="col-xs-3">
                <a class="esd-structure-preview"></a>
            </div>
            <div class="col-xs-3">
                <a class="esd-structure-preview"></a>
            </div>
                                </div>
                                <div class="esd-stripe-preview" esd-element-name="structureType_33_66">
                                    
            <div class="col-xs-4">
                <a class="esd-structure-preview"></a>
            </div>
            <div class="col-xs-8">
                <a class="esd-structure-preview"></a>
            </div>
                                </div>
                                <div class="esd-stripe-preview" esd-element-name="structureType_66_33">
                                    
            <div class="col-xs-8">
                <a class="esd-structure-preview"></a>
            </div>
            <div class="col-xs-4">
                <a class="esd-structure-preview"></a>
            </div>
                                </div>
                    </div>
                </div>
            </div>
         
           <table class="es-content-body" width="600" cellspacing="0" cellpadding="0" align="center" esd-img-prev-src="" style="background-color: transparent;"> 
            <tbody class="ui-droppable"> 
             <tr class="ui-draggable"> 
              <td class="esd-structure es-p40t es-p35b es-p35r es-p35l esd-frame esdev-disable-select" style="background-color: rgb(247, 247, 247);" bgcolor="#f7f7f7" align="left" esd-handler-name="structureBlockHandler">
            <div class="esd-structure-type">
        
            </div><div class="esd-block-btn ">
                    <div class="esd-more"><a><span class="es-icon-dot-3"></span></a></div>
                    
            <div class="esd-save" title="Save as module">
                <a><span class="es-icon-save"></span></a></div>
                    
                    <div class="esd-move ui-draggable-handle" title="Move">
                        <a><span class="es-icon-move"></span></a>
                    </div>
                    <div class="esd-copy ui-draggable-handle" title="Copy">
                        <a><span class="es-icon-copy"></span></a>
                    </div>
                    <div class="esd-delete" title="Delete" disabled="disabled">
                        <a><span class="es-icon-delete"></span></a>
                    </div>
                </div> 
               <table width="100%" cellspacing="0" cellpadding="0"> 
                <tbody class="ui-droppable"> 
                 <tr class="ui-draggable"> 
                  <td class="esd-container-frame esd-frame esdev-disable-select esd-hover" width="530" valign="top" align="center" esd-handler-name="containerHandler">
            <div class="esd-structure-type">
        
            </div><div class="esd-block-btn">
                    <div class="esd-more"><a><span class="es-icon-dot-3"></span></a></div>
                    
            <div class="esd-save" title="Save as module">
                <a><span class="es-icon-save"></span></a></div>
                    
                    <div class="esd-move ui-draggable-handle" title="Move">
                        <a><span class="es-icon-move"></span></a>
                    </div>
                    <div class="esd-copy ui-draggable-handle" title="Copy">
                        <a><span class="es-icon-copy"></span></a>
                    </div>
                    <div class="esd-delete" title="Delete">
                        <a><span class="es-icon-delete"></span></a>
                    </div>
                </div> 
                   <table width="100%" cellspacing="0" cellpadding="0"> 
                    <tbody class="ui-droppable"> 
                     <tr class="ui-draggable"> 
                      <td class="esd-block-image es-p20t es-p25b es-p35r es-p35l esd-frame esdev-disable-select esd-draggable esd-block esd-hover" align="center" style="font-size: 0px;" esd-handler-name="imgBlockHandler"><div class="esd-block-btn">
                    <div class="esd-more"><a><span class="es-icon-dot-3"></span></a></div>
                    
                    
                    <div class="esd-move ui-draggable-handle" title="Move">
                        <a><span class="es-icon-move"></span></a>
                    </div>
                    <div class="esd-copy ui-draggable-handle" title="Copy">
                        <a><span class="es-icon-copy"></span></a>
                    </div>
                    <div class="esd-delete" title="Delete">
                        <a><span class="es-icon-delete"></span></a>
                    </div>

                </div>
<img src="https://www.carasante.com/wp-content/uploads/2021/04/logocarasante-e1450701241142.png" alt="ship" style="display: block;" title="ship" width="150">
</td> 
                     </tr> 
                     <tr class="ui-draggable"> 
                      <td class="esd-block-text es-p15b esd-frame esd-draggable esd-block esd-hover esdev-disable-select" align="center" esd-handler-name="textElementHandler" contenteditable="true"><div class="esd-block-btn" contenteditable="false">
                    <div class="esd-more"><a><span class="es-icon-dot-3"></span></a></div>
                    
                    
                    <div class="esd-move ui-draggable-handle" title="Move">
                        <a><span class="es-icon-move"></span></a>
                    </div>
                    <div class="esd-copy ui-draggable-handle" title="Copy">
                        <a><span class="es-icon-copy"></span></a>
                    </div>
                    <div class="esd-delete" title="Delete">
                        <a><span class="es-icon-delete"></span></a>
                    </div>
                </div><h2 style="color: #333333; font-family: \'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;">Un administrateur a décidé de désactiver votre compte...</h2></td> 
                     </tr> 
                     <tr class="ui-draggable"> 
                      <td class="esd-block-text es-m-txt-l es-p20t esd-frame esd-draggable esd-block esd-hover esdev-disable-select" align="left" esd-handler-name="textElementHandler" contenteditable="true"><div class="esd-block-btn " contenteditable="false">
                    <div class="esd-more"><a><span class="es-icon-dot-3"></span></a></div>
                    
                    
                    <div class="esd-move ui-draggable-handle" title="Move">
                        <a><span class="es-icon-move"></span></a>
                    </div>
                    <div class="esd-copy ui-draggable-handle" title="Copy">
                        <a><span class="es-icon-copy"></span></a>
                    </div>
                    <div class="esd-delete" title="Delete">
                        <a><span class="es-icon-delete"></span></a>
                    </div>
                </div><h3 style="font-size: 18px;">Merci d\'avoir participé(e) à l\'aventure Cara Santé via Liora, '. $firstName .' !</h3></td> 
                     </tr> 
                     <tr class="ui-draggable"> 
                      <td class="esd-block-text es-p15t es-p10b esd-frame esd-draggable esd-block esd-hover esdev-disable-select" align="left" esd-handler-name="textElementHandler" contenteditable="true"><div class="esd-block-btn" contenteditable="false">
                    <div class="esd-more"><a><span class="es-icon-dot-3"></span></a></div>
                    
                    
                    <div class="esd-move ui-draggable-handle" title="Move">
                        <a><span class="es-icon-move"></span></a>
                    </div>
                    <div class="esd-copy ui-draggable-handle" title="Copy">
                        <a><span class="es-icon-copy"></span></a>
                    </div>
                    <div class="esd-delete" title="Delete">
                        <a><span class="es-icon-delete"></span></a>
                    </div>
                </div><p style="font-size: 16px; color: #777777;">'. $countSentence .'</p></td> 
                     </tr> 
                     <tr class="ui-draggable"> 
                      <td class="esd-block-button es-p25t es-p20b es-p10r es-p10l esd-frame esdev-disable-select esd-draggable esd-block esd-hover" align="center" esd-handler-name="btnBlockHandler"><div class="esd-block-btn">
                    <div class="esd-more"><a><span class="es-icon-dot-3"></span></a></div>
                    
                    
                    <div class="esd-move ui-draggable-handle" title="Move">
                        <a><span class="es-icon-move"></span></a>
                    </div>
                    <div class="esd-copy ui-draggable-handle" title="Copy">
                        <a><span class="es-icon-copy"></span></a>
                    </div>
                    <div class="esd-delete" title="Delete">
                        <a><span class="es-icon-delete"></span></a>
                    </div>
                </div></td> 
                     </tr> 
                    </tbody> 
                   </table></td> 
                 </tr> 
                </tbody> 
               </table></td> 
             </tr> 
              
            </tbody> 
           </table></td> 
         </tr> 
        </tbody> 
       </table> 
        
       <table class="es-footer ui-draggable" cellspacing="0" cellpadding="0" align="center"> 
        <tbody> 
         <tr> 
          <td class="esd-stripe esd-frame esdev-disable-select esd-hover" align="center" esd-handler-name="stripeBlockHandler">
            <div class="esd-structure-type">
        
            </div><div class="esd-block-btn">
                    <div class="esd-more"><a><span class="es-icon-dot-3"></span></a></div>
                    
            <div class="esd-save" title="Save as module">
                <a><span class="es-icon-save"></span></a></div>
                    
                    <div class="esd-move ui-draggable-handle" title="Move">
                        <a><span class="es-icon-move"></span></a>
                    </div>
                    <div class="esd-copy ui-draggable-handle" title="Copy">
                        <a><span class="es-icon-copy"></span></a>
                    </div>
                    <div class="esd-delete" title="Delete">
                        <a><span class="es-icon-delete"></span></a>
                    </div>
                </div>
            <div class="esd-add-stripe">
                <a><span class="es-icon-plus"></span></a>
                <div class="esd-stripes-popover esd-hidden-right">
                    <div class="esd-popover-content">
                        
                                <div class="esd-stripe-preview" esd-element-name="structureType_100">
                                    
            <div class="col-xs-12">
                <a class="esd-structure-preview"></a>
            </div>
                                </div>
                                <div class="esd-stripe-preview" esd-element-name="structureType_50_50">
                                    
            <div class="col-xs-6">
                <a class="esd-structure-preview"></a>
            </div>
            <div class="col-xs-6">
                <a class="esd-structure-preview"></a>
            </div>
                                </div>
                                <div class="esd-stripe-preview" esd-element-name="structureType_33_33_33">
                                    
            <div class="col-xs-4">
                <a class="esd-structure-preview"></a>
            </div>
            <div class="col-xs-4">
                <a class="esd-structure-preview"></a>
            </div>
            <div class="col-xs-4">
                <a class="esd-structure-preview"></a>
            </div>
                                </div>
                                <div class="esd-stripe-preview" esd-element-name="structureType_25_25_25_25">
                                    
            <div class="col-xs-3">
                <a class="esd-structure-preview"></a>
            </div>
            <div class="col-xs-3">
                <a class="esd-structure-preview"></a>
            </div>
            <div class="col-xs-3">
                <a class="esd-structure-preview"></a>
            </div>
            <div class="col-xs-3">
                <a class="esd-structure-preview"></a>
            </div>
                                </div>
                                <div class="esd-stripe-preview" esd-element-name="structureType_33_66">
                                    
            <div class="col-xs-4">
                <a class="esd-structure-preview"></a>
            </div>
            <div class="col-xs-8">
                <a class="esd-structure-preview"></a>
            </div>
                                </div>
                                <div class="esd-stripe-preview" esd-element-name="structureType_66_33">
                                    
            <div class="col-xs-8">
                <a class="esd-structure-preview"></a>
            </div>
            <div class="col-xs-4">
                <a class="esd-structure-preview"></a>
            </div>
                                </div>
                    </div>
                </div>
            </div>
         
           <table class="es-footer-body" width="600" cellspacing="0" cellpadding="0" align="center" esd-img-prev-src=""> 
            <tbody class="ui-droppable"> 
             <tr class="ui-draggable"> 
              <td class="esd-structure es-p35t es-p40b es-p35r es-p35l esd-frame esdev-disable-select esd-hover" align="left" esd-handler-name="structureBlockHandler">
            <div class="esd-structure-type">
        
            </div><div class="esd-block-btn">
                    <div class="esd-more"><a><span class="es-icon-dot-3"></span></a></div>
                    
            <div class="esd-save" title="Save as module">
                <a><span class="es-icon-save"></span></a></div>
                    
                    <div class="esd-move ui-draggable-handle" title="Move">
                        <a><span class="es-icon-move"></span></a>
                    </div>
                    <div class="esd-copy ui-draggable-handle" title="Copy">
                        <a><span class="es-icon-copy"></span></a>
                    </div>
                    <div class="esd-delete" title="Delete" disabled="disabled">
                        <a><span class="es-icon-delete"></span></a>
                    </div>
                </div> 
               <table width="100%" cellspacing="0" cellpadding="0"> 
                <tbody class="ui-droppable"> 
                 <tr class="ui-draggable"> 
                  <td class="esd-container-frame esd-frame esdev-disable-select esd-hover" width="530" valign="top" align="center" esd-handler-name="containerHandler">
            <div class="esd-structure-type">
        
            </div><div class="esd-block-btn ">
                    <div class="esd-more"><a><span class="es-icon-dot-3"></span></a></div>
                    
            <div class="esd-save" title="Save as module">
                <a><span class="es-icon-save"></span></a></div>
                    
                    <div class="esd-move ui-draggable-handle" title="Move">
                        <a><span class="es-icon-move"></span></a>
                    </div>
                    <div class="esd-copy ui-draggable-handle" title="Copy">
                        <a><span class="es-icon-copy"></span></a>
                    </div>
                    <div class="esd-delete" title="Delete">
                        <a><span class="es-icon-delete"></span></a>
                    </div>
                </div> 
                   <table width="100%" cellspacing="0" cellpadding="0"> 
                    <tbody class="ui-droppable"> 
                      
                      
                     <tr class="ui-draggable"> 
                      <td esdev-links-color="#777777" align="left" class="esd-block-text es-m-txt-c es-p5b esd-frame esd-draggable esd-block esd-hover esdev-disable-select" esd-handler-name="textElementHandler" contenteditable="true"><div class="esd-block-btn " contenteditable="false">
                    <div class="esd-more"><a><span class="es-icon-dot-3"></span></a></div>
                    
                    
                    <div class="esd-move ui-draggable-handle" title="Move">
                        <a><span class="es-icon-move"></span></a>
                    </div>
                    <div class="esd-copy ui-draggable-handle" title="Copy">
                        <a><span class="es-icon-copy"></span></a>
                    </div>
                    <div class="esd-delete" title="Delete">
                        <a><span class="es-icon-delete"></span></a>
                    </div>
                </div><p style="color: #777777; font-size: 12px;">Vous recevez ce mail car un administrateur de l\'application '. $_ENV['FRONT_URL'] .' a désactivé votre compte.</p></td> 
                     </tr> 
                    </tbody> 
                   </table></td> 
                 </tr> 
                </tbody> 
               </table></td> 
             </tr> 
            </tbody> 
           </table></td> 
         </tr> 
        </tbody> 
       </table> 
       </td> 
     </tr> 
    </tbody> 
   </table> 
  </div>  
 </body></html>
        ';
    }
}