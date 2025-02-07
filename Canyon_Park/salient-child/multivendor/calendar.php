<?php /* Template Name: Calendar */ ?>
<?php

include "includes/styles.php";

?>


    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/tables/datatable/buttons.bootstrap5.min.css">
    <style>
    

        div#calendar_header {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        div#calendar_header .fa.fa-angle-left:before {
            content: "\f104" !important;
        }

        div#calendar_header .fa.fa-angle-right:before {
            content: "\f105" !important;
        }

        #calendar {
            /* margin-right: 2%; */
            /* width: 565px !important; */
            width: 100% !important;
            font-family: 'Lato', sans-serif;
        }

        .col.span_12.price {
            margin-top: 20px;
        }

        #calendar_weekdays div{
            display:inline-block;
            vertical-align:top;
        }
        #calendar_content, #calendar_weekdays, #calendar_header {
            position: relative;
            width: 100% !important;
            overflow: hidden;
            float: left;
            z-index: 10;
        }

        #calendar_weekdays div, #calendar_content div {
            width: 100%!important;
            height: 50px !important;
            overflow: hidden;
            text-align: center;
            background-color: #FFFFFF;
            color: #333232;
        }

        #calendar_weekdays, #calendar_content {
            display: grid !important;
            grid-template-columns: auto auto auto auto auto auto auto;
            grid-gap: 0px;
        }

        #calendar_content{
            -webkit-border-radius: 0px 0px 12px 12px;
            -moz-border-radius: 0px 0px 12px 12px;
            border-radius: 0px 0px 12px 12px;
        }

        #calendar_content div{
            float: left;
        }

        #calendar_content div:hover{
            background-color: #F8F8F8;
        }

        #calendar_content div.blank{
            background-color: #E8E8E8;
        }

        #calendar_header, #calendar_content div.active{
            zoom: 1;
            filter: alpha(opacity=70);
            /* opacity: 0.7; */
        }

        #calendar_content div.active {
            color: #FFFFFF;
            /* background-color: #ea6783; */
            background: linear-gradient(118deg, #E39F55, #E39F55a6);
        }

        div#calendar_header {
            background: linear-gradient(180deg, #c78237, #f9b66ea6);
        }
        #calendar_header{
            width: 100%;
            /* height: 37px; */
            text-align: center;
            /* background-color: #191970; */
            background-color: rgb(184 96 249);
            padding: 14px 0px 5px 0px;
            -webkit-border-radius: 12px 12px 0px 0px;
            -moz-border-radius: 12px 12px 0px 0px;
            border-radius: 12px 12px 0px 0px;
        }

        #calendar_header h1{
            font-size: 1.5em;
            color: #FFFFFF;
            float:left;
            width:70%;
        }

        i[class^=icon-chevron]{
            color: #FFFFFF;
            float: left;
            width:15%;
            border-radius: 50%;
        }

        .fa-angle-left:before ,.fa-angle-right:before {
            font-family: 'FontAwesome';
            cursor: pointer;

        }
        .select-date {
            cursor: pointer;
            font-weight: bold;
        }

        #calendar .disabled {
            cursor: not-allowed;
            opacity: 0.65;
        }
        div#calendar_header svg {
            color: #ffffff;
            width: 60px;
            height: 30px;
        }
        #calendar_content div {
            border: 1px solid #efaa5ca8;
            height: 90px !important;
            line-height: 30px !important;
            display: grid;
            justify-content: center;
            align-items: center;
        }

        #calendar_weekdays div {
            background: linear-gradient(160deg, #E39F55, #E39F55a6);
            color: white !important;
        }
    </style>
<!-- END: Head-->
<?php include "includes/header.php"; ?>


<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="">

    <!-- BEGIN: Header-->
   
    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->
   <?php include "includes/manu.php"; ?>
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
        
            <div class="content-body">
                <!-- users list start -->
                <section class="app-user-list">
                  
                    <!-- list and filter start -->
                    <div class="card">
                        <!-- <div class="card-body border-bottom"> -->
                            <!-- <h4 class="card-title">Invoices</h4> -->
                        <!-- </div> -->

                        <div class="col span_12" id="calendar">
						<!-- <label class="form-label" >Select Time Slots</label> -->
                        <div id="calendar_header">
                            <i class="icon-chevron-left fa-angle-left">
                                <i  data-feather='chevron-left'></i>
                            </i>
                            <h1></h1>
                            <i class="icon-chevron-right fa-angle-right">
                                <i data-feather='chevron-right'></i>
                            </i>
                        </div>
                        <div id="calendar_weekdays"></div>
                        <div id="calendar_content"></div>
                    </div>
                    </div>
                    <!-- list and filter end -->
                </section>
                <!-- users list ends -->

            </div>
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

   

    <?php include "includes/scripts.php"; ?>



    <script>
        toastr.options = {
            "closeButton": true,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "2000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }

        var days = <?= json_encode(isset($meta['slots'][0]) ? array_column(unserialize($meta['slots'][0]) ?? [], 'days') : ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']); ?>;
        var blackOutDate =[];
        var monthLimit = 365;

        function setCalender(){
            $(function () {
            function c() {
                p();
                var e = h();
                var r = 0;
                var u = false;
                l.empty();
                while (!u) {
                if (s[r] == e[0].weekday) {
                    u = true;
                } else {
                    l.append('<div class="blank"></div>');
                    r++;
                }
                }
                for (var c = 0; c < 42 - r; c++) {
                    if (c >= e.length) {
                        l.append('<div class="blank"></div>');
                    } else {
                        var v = e[c].day;
                        var  date1 = t+"/"+n+"/"+v;
                        var limit3month = twoDateDiffr(new Date(t, n - 1, v));
                        var attr = 'weekday="'+e[c].weekday+'" day="'+v+'" month="'+ n +'" year="'+t+'" date="'+date1+'"';
                        var blockDate = ifBlockDate(date1);
                        var allowDate = jQuery.inArray( e[c].weekday, days) !== -1;
                        var ifActive = (gNew(new Date(t, n - 1, v)) && allowDate && limit3month && blockDate) ? "select-date" : "disabled";
                        var m = g(new Date(t, n - 1, v)) ? '<div '+attr+' class="active '+ifActive+'">' : '<div '+attr+' class="'+ifActive+'">';
                        l.append(m + "" + v + "<br><span>45 = "+addDaysToDate(date1, 45)+"</span></div>");
                    }
                }
                var y = o[n - 1];
                a.css("background-color", y)
                .find("h1")
                .text(i[n - 1] + " " + t);
                f.find("div").css("color", y);
                // l.find(".active").css("background-color", y);
                // l.find(".active").css("background-color", '#191970');
                d();
            }

            function addDaysToDate(date, days) {
                const result = new Date(date); // Create a new Date object to avoid modifying the original
                result.setDate(result.getDate() + days); // Add the number of days
                var date =  result;
                const day = date.getDate(); // Get the day
                const month = date.getMonth() + 1; // Get the month (0-based, so add 1)
                const year = date.getFullYear(); // Get the year
                return `${month}/${day}/${year}`; 
            }

            function ifBlockDate(date) {
                let parts = date.split('/'); // Split the date string by '/'
                let year = parts[0]; // Extract year
                let month = parts[1].padStart(2, '0'); // Extract month and pad with zero if needed
                let day = parts[2].padStart(2, '0'); // Extract day and pad with zero if needed

                let newDate = `${year}/${month}/${day}`;
                return jQuery.inArray( newDate, blackOutDate) == -1;
            }

            function twoDateDiffr(start){
                var end= new Date();
                tempDays = (start - end) / (1000 * 60 * 60 * 24);
                return (monthLimit) ? Math.round(tempDays) < monthLimit : true;
                // if (sectionLimit == 1) {
                //     return Math.round(tempDays) < 31;
                // } else if (sectionLimit == 4) {
                //     return Math.round(tempDays) < 121;
                // } else if (sectionLimit == 12) {
                //     return Math.round(tempDays) < 181;
                // } else if (sectionLimit == 24) {
                //     return Math.round(tempDays) < 365;
                // } else{
                //     return Math.round(tempDays) < 91;
                // }
            }
            function h() {
                var e = [];
                for (var r = 1; r < v(t, n) + 1; r++) {
                e.push({ day: r, weekday: s[m(t, n, r)] });
                }
                return e;
            }
            function p() {
                f.empty();
                for (var e = 0; e < 7; e++) {
                f.append("<div>" + s[e].substring(0, 3) + "</div>");
                }
            }
            function d() {
                var t;
                var n = $("#calendar").css("width", e+28 + "px");
                n.find((t = "#calendar_weekdays, #calendar_content"))
                .css("width", e + "px")
                .find("div")
                .css({
                    width: e / 7 + "px",
                    height: e / 7 + "px",
                    "line-height": e / 7 + "px"
                });
                n.find("#calendar_header")
                // .css({ height: e * (1 / 5) + "px" })
                // .find('i[class^="icon-chevron"]')
                // .css("line-height", e * (1 / 7) + "px");
            }
            function v(e, t) {
                return new Date(e, t, 0).getDate();
            }
            function m(e, t, n) {
                return new Date(e, t - 1, n).getDay();
            }
            function g(e) {
                return y(new Date()) == y(e);
            }
            function gNew(e) {
                // console.log(y(new Date()), y(e))
                // console.log(    new Date(y(new Date())).getTime() , e.getTime() )
                return new Date(y(new Date())).getTime() < e.getTime();
                // return y(new Date()) > y(e);
            }
            function y(e) {
                return e.getFullYear() + "/" + (e.getMonth() + 1) + "/" + e.getDate();
            }
            function b() {
                var e = new Date();
                t = e.getFullYear();
                n = e.getMonth() + 1;
            }
            var e = 480;
            var e = 350;
            var t = 2013;
            var n = 9;
            var r = [];
            var i = [
                "JANUARY",
                "FEBRUARY",
                "MARCH",
                "APRIL",
                "MAY",
                "JUNE",
                "JULY",
                "AUGUST",
                "SEPTEMBER",
                "OCTOBER",
                "NOVEMBER",
                "DECEMBER"
            ];
            var s = [
                "Sunday",
                "Monday",
                "Tuesday",
                "Wednesday",
                "Thursday",
                "Friday",
                "Saturday"
            ];
            var o = [
                "#f18ea4",
                "#f18ea4",
                "#f18ea4",
                "#f18ea4",
                "#f18ea4",
                "#f18ea4",
                "#f18ea4",
                "#f18ea4",
                "#f18ea4",
                "#f18ea4",
                "#f18ea4",
                "#f18ea4",
                "#f18ea4",
                "#f18ea4",
                "#f18ea4",
                "#f18ea4"
            ];
            var u = $("#calendar");
            var a = u.find("#calendar_header");
            var f = u.find("#calendar_weekdays");
            var l = u.find("#calendar_content");
            b();
            c();
            a.find('i[class^="icon-chevron"]').on("click", function () {
                var e = $(this);
                var r = function (e) {
                n = e == "next" ? n + 1 : n - 1;
                if (n < 1) {
                    n = 12;
                    t--;
                } else if (n > 12) {
                    n = 1;
                    t++;
                }
                c();
                };
                if (e.attr("class").indexOf("left") != -1) {
                r("previous");
                } else {
                    r("next");
                }
            });
            });
        }

        setCalender()
     
    </script>
    
</body>
<!-- END: Body-->

<!-- </html> -->