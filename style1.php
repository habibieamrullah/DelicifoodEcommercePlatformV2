/* SCROLLBAR STYLING */
/* width */
::-webkit-scrollbar {
    width: 2px;
	height: 2px;
}
/* Track */
::-webkit-scrollbar-track {
    background: white; 
}
/* Handle */
::-webkit-scrollbar-thumb {
    background: black; 
}
/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
    background: #555; 
}

h1, h2, h3, h4, h5, p{
    margin: 0px;
    margin-bottom: 10px;
}

p{
    font-size: 20px;
    margin-bottom: 15px;
}

.invisibleblock{
    display: none;
}

body{
    padding: 0px;
    margin: 0px;
    padding-top: 100px;
    font-family: 'Dosis', sans-serif;
    background-color: #4a4a4a;
    
    
    background: url(images/footerimage.jpg) no-repeat fixed center; 
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
}
#appbar{
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    
    z-index: 10;
    
    background: <?php echo $primarycolor ?>;
    background: linear-gradient(90deg, <?php echo $primarycolordarker ?> 0%, <?php echo $primarycolor ?> 100%);
    
    /*background-color: <?php echo $primarycolor ?>;*/
    color: white;
    
    padding: 10px;
}



#footer{
    text-align: center;
    padding: 50px;
    color: white;
    font-size: 14px;

}


.middle{
    background-color: #f9f9f9;
    padding: 20px;
}

.footeritem{
    
    display: inline-block;
    padding: 10px;
    cursor: pointer;
    
}

.footeritem:hover{
    text-decoration: underline;
}

a{
    text-decoration: none;
    color: inherit;
}

.textlink{
    cursor: pointer;
    color: <?php echo $primarycolor ?>;
}
.textlink:hover{
    text-decoration: underline;
}

input, button, textarea, select{
    box-sizing: border-box;
    width: 100%;
    padding: 20px;
    border: 1px solid <?php echo $primarycolor ?>;
    border-radius: 5px;
    margin-bottom: 20px;
}

textarea{
    height: 100px;
}

button, .submitbutton{
    background-color: <?php echo $primarycolor ?>;
    cursor: pointer;
    color: white;
    font-weight: bold;
}

.submitbutton:hover{
    background-color: <?php echo $primarycolordarker ?>;
}

.chatbutton{
    display: inline-block;
    border-radius: 10px;
    padding: 20px;
    color: white;
    font-size: 20px;
    text-align: center;
    margin-bottom: 10px;
    /*background-color: <?php echo $primarycolor ?>;*/
    border: 2px solid <?php echo $primarycolor ?>;
    cursor: pointer;
    font-weight: bold;
    color: <?php echo $primarycolor ?>;
}

.chatbutton:hover{
    background-color: <?php echo $primarycolordarker ?>;
    color: white;
}

#mainbanner{
    background: url(images/mainbanner.jpg) no-repeat center center; 
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
    
    padding: 50px;
    
    text-align: center;
    color: white;
    font-size: 40px;
}

.middlebox{
    margin: 0 auto;
    max-width: 920px;
}



.productthumbnail{
    background-color: white;
    padding: 10px;
    cursor: pointer;
    border: 1px solid white;
    text-align: left;
    margin: 10px;
    -webkit-box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.15);
    -moz-box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.15);
    box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.15);
}

.pricetag{
    padding: 10px; font-size: 20px; color: white; background-color: rgba(0,0,0,.5);
}

.productthumbnail:hover .pricetag{
    background-color: <?php echo $primarycolor ?>;
}

.productthumbnail:hover{
    border: 1px solid <?php echo $primarycolor ?>;
}

#appbarmenu{
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0,0,0,.8);
    display: none;
    min-width: 128px;
}

.ablink{
    display: block;
    padding: 20px;
    cursor: pointer;
    text-align: right;
}

.mobilevisible{
    display: block;
}

#mobilebutton{
    position: fixed;
    color: white;
    top: 0;
    right: 0;
    padding: 40px;
}

.thumbnailimage{
    width: 100%;
    height: 200px;
}

.shorttext{
	width: 100%;
	display: inline-block;
	text-overflow: ellipsis;
	white-space: nowrap;
	overflow: hidden;
}

.singleproductholder{
    display: block;
}

.singleproductrow{
    display: block;
}

.dashboardcontentholder{
    display: block;
}

.dashboardcell{
    display: block; 
    margin-bottom: 20px;
}

.dashboardleftbutton{
    border-bottom: 1px solid white;
    cursor: pointer;
    display: inline-block;
    padding: 10px;
}
.dashboardleftbutton:hover{
    color: <?php echo $primarycolor ?>;
    font-weight: bold;
    background-color: white;
}

@media (min-width: 720px){
    
    .thumbnailimage{
        width: 200px; height: 200px; 
    }
    
    .shorttext{
        width: 200px;
    }
    
    .productthumbnail{
        display: inline-block;
        vertical-align: top;
        width: 200px;
    }
    
    #appbarmenu{
        display: inline-block; position: absolute; right: 20px; top: 20%;
        background-color: inherit;
    }
    .ablink{
        display: inline-block;
        padding: 20px;
        cursor: pointer;
    }
    .mobilevisible{
        display: none;
    }
    
    .singleproductholder{
        display: table;
        width: 100%;
    }
    
    .singleproductrow{
        display: table-cell;
        vertical-align: top;
    }
    
    .sprleft{
        width: 300px;
    }
    
    .sprright{
        padding-left: 20px;
    }
    
    .dashboardcontentholder{
        display: table; width: 100%;
    }
    
    .dashboardcell{
        display: table-cell; 
    }
    
    .dbcleft{
        width: 128px;
    }
    
    .dbcright{
        padding-left: 30px;
    }
    
    .dashboardleftbutton{
        display: block;
    }
}



.ablink:hover{
    background-color: <?php echo $primarycolordarker ?>;
}

.bigproductimage{
    margin-bottom: 10px; 
    margin-top: 10px;
    padding: 10px; 
    background-color: white;
    -webkit-box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.15);
    -moz-box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.15);
    box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.15);
}

#searchbox{
    margin-bottom: 10px; 
    margin-top: 10px;
    padding: 25px; background-color: white;
    -webkit-box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.15);
    -moz-box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.15);
    box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.15);
    
    font-size: 30px;
    color: <?php echo $primarycolor ?>;
    
    display: table;
    width: 100%;
    border-radius: 30px;
    box-sizing: border-box;
}

.sbitem{
    display: table-cell;
    vertical-align: middle;
}


label{
    font-weight: bold;
}

.messaging{
    border: 1px solid <?php echo $primarycolor ?>;
    border-radius: 10px;
    padding: 10px;
    
    background: url(images/chatbg.jpg) repeat; 
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
    
}
.messaging p{
    font-size: 14px;
}



table {
    border-collapse: collapse;
    width: 100%;
}

table, th, td {
    border: 1px solid gray;
    font-size: 14px;
}

th{
    text-align: center;
    font-weight: bold;
    background-color: <?php echo $primarycolor ?>;
    color: white;
}

th, td{
    padding: 10px;
    cursor: pointer;
}

tr:hover{
    background-color: white;
    color: <?php echo $primarycolor ?>;
}

.msg{
    border: 1px solid gray;
    background-color: white;
    margin: 5px;
    border-radius: 20px 0px 20px 20px;
    padding: 10px;
    display: inline-block;
}

.msgthatperson{
    background-color: <?php echo $primarycolor ?>;
    margin: 5px;
    border-radius: 0px 20px 20px 20px;
    padding: 10px;
    color: white;
    display: inline-block;
}

.msgtimestamp{
    font-size: 12px;
    padding: 5px;
}


.msgbody{
    font-size: 17px;
    padding: 5px;
}

#onlinestatus{
    background-color: gray;
    color: white;
    padding: 3px 5px 3px 5px;
    border-radius: 20px;
    font-size : 10px;
}

#chats{
    display: table;
    width: 100%;
    border: 1px solid <?php echo $primarycolor ?>;
    border-radius: 10px;
    padding-bottom: 20px;
    padding-top: 20px;
    
    background: url(images/chatbg.jpg) repeat; 
    
}

#chatmessages{
    display: table-cell;
    width: 250px;
    vertical-align: top;
}

#chatconversations{
    display: table-cell;
    padding: 20px;
    vertical-align: top;
}

.chatmessageschild{
    padding: 10px;
    cursor: pointer;
}

.chatmessageschild:hover{
    color: white;
    background-color: <?php echo $primarycolor ?>;
}

#currentchatconversation{
    max-height: 300px;
    overflow: auto;
}