/*!
 * SATS (www.wisdmlabs.com)
 * Copyright 2019 SATS
 * Licensed under the http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
/*!
 * remark (http://getbootstrapadmin.com/remark)
 * Copyright 2019 amazingsurge
 * Licensed under the Themeforest Standard Licenses
 */

define(["jquery","./tether","./babel-external-helpers","./breakpoints"],function(jQuery,Tether,babelHelpers,breakpoints){window.jQuery=jQuery,window.Tether=Tether,window.babelHelpers=babelHelpers,require(["theme_tilemmetry/bootstrap","theme_tilemmetry/jquery-mousewheel","theme_tilemmetry/jquery-asScrollbar","theme_tilemmetry/jquery-asScrollable","theme_tilemmetry/jquery-asHoverScroll","theme_tilemmetry/screenfull","theme_tilemmetry/jquery-slidePanel","theme_tilemmetry/State","theme_tilemmetry/Base","theme_tilemmetry/Plugin","theme_tilemmetry/Config","theme_tilemmetry/Menubar","theme_tilemmetry/Sidebar","theme_tilemmetry/PageAside","theme_tilemmetry/menu","theme_tilemmetry/asscrollable","theme_tilemmetry/slidepanel","theme_tilemmetry/skintools","theme_tilemmetry/Tilemmetry","core/templates","theme_tilemmetry/jquery-toolbar"],function(BS,mw,asb,asbl,ahs,sfl,spnl,State,Base,Plugin,Config,Menubar,Sidebar,PageAside,menu,Scrollable,SlidePanel,skintools,Tilemmetry,templates,toolbar){function getCourses(button,loaderimg,lengthof,totalcoursecount,template){jQuery("#"+button).prop({disabled:!0,style:"cursor: auto"}),jQuery("#"+loaderimg).show();var search=jQuery("#coursesearchbox").val();search||(search="");var categoryid=jQuery("select[name='categoryid']").val();categoryid||(categoryid=0);var startfrom=jQuery(lengthof+" div .card").length,mycourses=jQuery("input[name='mycourses']").val(),categorysort=jQuery("select[name='categorysort']").val().replace("SORT_","");jQuery.ajax({type:"GET",async:!0,url:M.cfg.wwwroot+"/theme/tilemmetry/request_handler.php?action=get_courses_ajax&totalcourses="+!1+"&search="+search+"&categoryid="+categoryid+"&startfrom="+startfrom+"&limitto=4&mycourses="+mycourses+"&categorysort="+categorysort,success:function(response){for(var i=0;i<response.length;i++){var context=response[i];templates.render(template,context).then(function(html,js){templates.appendNodeContents(lengthof,html,js),jQuery.each(jQuery(".showoptions"),function(){jQuery(this).toolbar({content:jQuery(this).data("toolbar"),style:"primary"})}),jQuery(".tool-item").on("click",function(){window.location=jQuery(this).attr("href")})}).fail(function(ex){jQuery("#"+loaderimg).hide(),jQuery("#"+button).blur(),jQuery("#"+button).prop({disabled:!1,style:"cursor: auto"})})}jQuery("#"+loaderimg).hide(),jQuery("#"+button).blur();var totalcoursecount1=jQuery("input[name="+totalcoursecount+"]").val();startfrom+4<totalcoursecount1&&jQuery("#"+button).prop({disabled:!1,style:"cursor: auto"})},error:function(xhr,status,error){jQuery("#"+loaderimg).hide(),jQuery("#"+button).blur(),jQuery("#"+button).prop({disabled:!1,style:"cursor: auto"})}})}function changeViewToggler(par){var activeClass="list_btn",passiveClass="grid_btn",removeClass="col-lg-3 col-md-6 gridview",addClass="col-lg-12 col-md-12 listview",state="list",addimgClass="listStyle",removeimgClass="gridStyle",addcardfooter="list-activity-buttons",addprogress="list-progress";0==par?(activeClass="grid_btn",passiveClass="list_btn",removeClass="col-lg-12 col-md-12 listview",addClass="col-lg-3 col-md-6 gridview",state="grid",addimgClass="gridStyle",removeimgClass="listStyle",jQuery(".activity-btn").removeClass(addcardfooter),jQuery(".progress.progress-xs").removeClass(addprogress),addprogress="",addcardfooter="",jQuery(".card-footer > a").removeClass("start-course-list")):jQuery(".card-footer > a").addClass("start-course-list"),jQuery("."+passiveClass).removeClass("active"),jQuery("."+activeClass).addClass("active"),jQuery("#categoryCourses").children("div").removeClass(removeClass),jQuery("#categoryCourses").children("div").addClass(addClass),jQuery("#mycategoryCourses").children("div").removeClass(removeClass),jQuery("#mycategoryCourses").children("div").addClass(addClass),jQuery(".instructor-img").removeClass(removeimgClass),jQuery(".instructor-img").addClass(addimgClass),jQuery(".activity-btn").addClass(addcardfooter),jQuery(".progress.progress-xs").addClass(addprogress),M.util.set_user_preference("course_view_state",state,null)}Tilemmetry.run(),jQuery("a[href='#mycoursestab']").on("click",function(){jQuery("input[name='mycourses']").val("1")}),jQuery("a[href='#coursestab']").on("click",function(){jQuery("input[name='mycourses']").val("0")}),jQuery(document).ready(function(){if(-1!=window.location.href.indexOf("mycourses=1"))var c=!0;1==c?(jQuery("a[href='#mycoursestab']").trigger("click"),jQuery("a[href='#coursestab']").removeClass("active"),jQuery("#coursestab").removeClass("active"),jQuery("a[href='#mycoursestab']").addClass("active"),jQuery("#mycoursestab").addClass("active")):(jQuery("a[href='#coursestab']").trigger("click"),jQuery("a[href='#mycoursestab']").removeClass("active"),jQuery("#mycoursestab").removeClass("active"),jQuery("a[href='#coursestab']").addClass("active"),jQuery("#coursestab").addClass("active"));var totalcoursecount=jQuery('input[name="totalmycoursecount"]').val(),startfrom=jQuery("#mycategoryCourses div .card").length;startfrom>=totalcoursecount&&jQuery("#myCourseArchivebtn").prop({disabled:!0,style:"cursor: auto"});totalcoursecount=jQuery('input[name="totalcoursecount"]').val();(startfrom=jQuery("#categoryCourses div .card").length)>=totalcoursecount&&jQuery("#courseArchivebtn").prop({disabled:!0,style:"cursor: auto"})}),jQuery("#myCourseArchivebtn").on("click",function(e){e.preventDefault();getCourses("myCourseArchivebtn","tilemmetrymyloaderimage","#mycategoryCourses","totalmycoursecount","theme_tilemmetry/my_course_card")}),jQuery("#courseArchivebtn").click(function(e){e.preventDefault();getCourses("courseArchivebtn","tilemmetryloaderimage","#categoryCourses","totalcoursecount","theme_tilemmetry/course_card")}),jQuery(".grid_btn").click(function(){changeViewToggler(!1)}),jQuery(".list_btn").click(function(){changeViewToggler(!0)})})});