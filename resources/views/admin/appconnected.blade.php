<!DOCTYPE html>
<html lang="en">
    <head>
        <base href="./" />
        <meta charset="utf-8" />
        <title>Individual Collective | Dashboard</title>
        <meta name="description" content="Updates and statistics" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <script>
            WebFont.load({
                google: {
                    families: ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700", ],
                },
                active: function() {
                    sessionStorage.fonts = true;
                },
            });
        </script>
        @include('/view-css')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" />
        <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.7/css/rowReorder.dataTables.min.css">

    </head>
    <body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--fixed kt-subheader--enabled kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">
        <div id="kt_header_mobile" class="kt-header-mobile kt-header-mobile--fixed">
            <div class="kt-header-mobile__logo">
                <a href="javascript:void(0)">
                    <img alt="Logo" src="../resources/assets/media/logos/logo-light.png" />
                </a>
            </div>     
            <button class="kt-header-mobile__toggler kt-header-mobile__toggler--left" id="kt_aside_mobile_toggler">
                <span></span>
            </button>
            <div class="kt-header-mobile__toolbar">
                <button class="kt-header-mobile__toggler kt-header-mobile__toggler--left" id="kt_aside_mobile_toggler">
                    <span></span>
                </button>
                <button class="kt-header-mobile__toggler" id="kt_header_mobile_toggler">
                    <span></span>
                </button>
            </div>
        </div>
        <div class="kt-grid kt-grid--hor kt-grid--root">
            <!-- Avtive Page Variable -->
            <?php $activepage = 'orderlist';?>

            @include('/side-nav')
            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">
                @include('/top-nav')
                <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">
                    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
                        <div class="kt-subheader__main">
                            <h3 class="kt-subheader__title">
                                Order Listing
                            </h3>
                            <span class="kt-subheader__separator kt-hidden"></span>
                            <div class="kt-subheader__breadcrumbs"></div>
                        </div>
                    </div>
                    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
                        <div class="kt-portlet">
                            <div class="kt-portlet__head kt-portlet__head--lg">
                                <div class="kt-portlet__head-label">
                                    <span class="kt-portlet__head-icon">
                                        <i class="kt-font-brand flaticon2-line-chart"></i>
                                    </span>
                                    <h3 class="kt-portlet__head-title">
                                        View Orders
                                    </h3>
                                </div>
                                <div class="kt-portlet__head-toolbar">
                                    <div class="kt-portlet__head-wrapper">
                                        <div class="kt-portlet__head-actions">
                                            <div class="dropdown dropdown-inline">                                          
                                                <a href="javascript:history.back()" class="btn btn-clean kt-margin-r-10">
                                                    <i class="la la-arrow-left"></i>
                                                    <span class="kt-hidden-mobile">Back</span>
                                                </a>                                             
                                            </div>
                                            &nbsp;
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="kt-portlet__body">
                                <ul class="nav nav-tabs nav-tabs-space-xl nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#kt_apps_user_edit_tab_1" role="tab">
                                            Paid
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#kt_apps_user_edit_tab_2" role="tab">
                                            Delivered
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#kt_apps_user_edit_tab_3" role="tab">
                                            Shipped 
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="kt_apps_user_edit_tab_1" role="tabpanel">
                                        <div class="kt-portlet__body table-responsive">
                                            <table id="kt_table_1" class="display" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Image</th>
                                                        <th>Order id</th>
                                                        <th>First name</th>
                                                        <th>Last name</th>                                                    
                                                        <th>Order type</th>
                                                        <th>Order date</th>
                                                        <th style="width:180px;">Sku-code</th>
                                                        <th>Amount</th>
                                                        <th>Status Update</th>
                                                        <th>Questionnaire Answers</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                        
                                        
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    
                                    <div class="tab-pane" id="kt_apps_user_edit_tab_2" role="tabpanel">

                                        <div class="kt-portlet__body table-responsive">
                                            <table id="kt_table_2" class="display" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Image</th>
                                                        <th>Order id</th>
                                                        <th>First name</th>
                                                        <th>Last name</th>
                                                        <th>Order type</th>
                                                        <th>Order date</th>
                                                        <th style="width:180px;">Sku-code</th>
                                                        <th>Amount</th>
                                                        <th>Status Update</th>
                                                        <th>Questionnaire Answers</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                   
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>


                                    <div class="tab-pane" id="kt_apps_user_edit_tab_3" role="tabpanel">

                                        <div class="kt-portlet__body table-responsive">
                                            <table id="kt_table_3" class="display" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Image</th>
                                                        <th>Order id</th>
                                                        <th>First name</th>
                                                        <th>Last name</th>
                                                        <th>Order type</th>
                                                        <th>Order date</th>
                                                        <th style="width:180px;">Sku-code</th>
                                                        <th>Amount</th>
                                                        <th>Status Update</th>
                                                        <th>Questionnaire Answers</th>                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('/footer')
            </div>
        </div>
        <div id="kt_scrolltop" class="kt-scrolltop">
            <i class="fa fa-arrow-up"></i>
        </div>
        
        @include('/view-js')        
        
    </body>
</html>