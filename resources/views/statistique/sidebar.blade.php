<style>
    @import url('https://fonts.googleapis.com/css?family=Roboto');

body{
	font-family: 'Roboto', sans-serif;
}
* {
	margin: 0;
	padding: 0;
}
i {
	margin-right: 10px;
}/* ---------horizontal-navbar-menu-----------*/
#navbar-animmenu {
	background: #84009c;
	float: left;
	overflow: hidden;
	position: relative;
	padding: 10px 0px;
  width: 100%;
}
#navbar-animmenu ul{
	padding: 0px;
	margin: 0px;
  
}

#navbar-animmenu ul li a i{
	margin-right: 10px;
}

#navbar-animmenu li {
	list-style-type: none;
	float: left;
}

#navbar-animmenu ul li a{
	color:  #fff;
    text-decoration: none;
    font-size: 15px;
    line-height: 45px;
    display: block;
    padding: 0px 20px;
    transition-duration:0.6s;
	transition-timing-function: cubic-bezier(0.68, -0.55, 0.265, 1.55);
    position: relative;
}

#navbar-animmenu>ul>li.active>a{
	color: #84009c;
	background-color: transparent;
	transition: all 0.7s;
}


#navbar-animmenu a:not(:only-child):after {
	content: "\f105";
	position: absolute;
	right: 20px;
	top: 10%;
	font-size: 14px;
	font-family: "Font Awesome 5 Free";
	display: inline-block;
	padding-right: 3px;
	vertical-align: middle;
	font-weight: 900;
	transition: 0.5s;
}

#navbar-animmenu .active>a:not(:only-child):after {
	transform: rotate(90deg);
}
.hori-selector{
	display:inline-block;
	position:absolute;
	height: 100%;
	top: 10px;
	left: 0px;
	transition-duration:0.6s;
	transition-timing-function: cubic-bezier(0.68, -0.55, 0.265, 1.55);
	background-color: #fff;
	border-top-left-radius: 15px;
	border-top-right-radius: 15px;
}
.hori-selector .right,
.hori-selector .left{
	position: absolute;
	width: 25px;
	height: 25px;
	background-color: #fff;
	bottom: 10px;
}
.hori-selector .right{
	right: -25px;
}
.hori-selector .left{
	left: -25px;
}
.hori-selector .right:before,
.hori-selector .left:before{
	content: '';
    position: absolute;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background-color: #84009c;
}
.hori-selector .right:before{
	bottom: 0;
    right: -25px;
}
.hori-selector .left:before{
	bottom: 0;
    left: -25px;
}
</style>
<div id="navbar-animmenu">
        <ul class="show-dropdown main-navbar">
            <div class="hori-selector"><div class="left"></div><div class="right"></div></div>
            <li  class="">
                <a href="/page_statistiques" onclick="javascript:void(0);"  ><i class="fas fa-tachometer-alt"></i>Inscriptions</a>
            </li>
            <li>
                <a href="/page_participants"><i class="far fa-address-book"></i>Participants</a>
            </li>
            <li>
                <a href="/page_rendez_vous"><i class="far fa-clone"></i>Entreprises</a>
            </li>
            <li>
                <a href="/page_rendez_vous_p"><i class="far fa-calendar-alt"></i>Rendez vous B2B</a>
            </li>
            <!--<li>
                <a href="/statistique_evenements"><i class="far fa-chart-bar"></i>Statistique de l’évnènement</a>
            </li>-->
            
            
        </ul>
    </div>
    
    <script>
        // ---------horizontal-navbar-menu-----------
		var tabsNewAnim = $('#navbar-animmenu');
		var selectorNewAnim = $('#navbar-animmenu').find('li').length;
		//var selectorNewAnim = $(".tabs").find(".selector");
		var activeItemNewAnim = tabsNewAnim.find('.active');
		var activeWidthNewAnimWidth = activeItemNewAnim.innerWidth();
		var itemPosNewAnimLeft = activeItemNewAnim.position();
		$(".hori-selector").css({
			"left":itemPosNewAnimLeft.left + "px",
			"width": activeWidthNewAnimWidth + "px"
		});
		$("#navbar-animmenu").on("click","li",function(e){
			$('#navbar-animmenu ul li').removeClass("active");
			$(this).addClass('active');
			var activeWidthNewAnimWidth = $(this).innerWidth();
			var itemPosNewAnimLeft = $(this).position();
			$(".hori-selector").css({
				"left":itemPosNewAnimLeft.left + "px",
				"width": activeWidthNewAnimWidth + "px"
			});
		});
    </script>