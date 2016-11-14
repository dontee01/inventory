
    <aside class="navigation">
        <nav>
            <div class="sidebar content-box-compose">
                <button id="compose" class="btn btn-lg btn-danger" data-toggle="modal" data-target="#myModal">Test</button>
            </div>

            <?php
            // include_once './modals/compose.php';
            // include_once './modals/compose-draft.php';
            // include_once './modals/schedule.php';
            // include_once './modals/add-file.php';
            // include_once './modals/add-file-draft.php';
            // include_once './modals/delete.php';
            // include_once './modals/delete-sent.php';
            // include_once './modals/delete-schedule.php';
            // include_once './modals/delete-notification.php';
            ?>
            <ul class="nav luna-nav" id="nav">

                <li >
                    <a class="nav-cat" href="#monitoring" data-toggle="collapse" aria-expanded="false"><img class="parent-icon" src="../images/message_icon.svg">
                        Transactions<span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
                    </a>
                    <ul id="monitoring" class="nav nav-second collapse nav-load">
                        <li><a class="icon-send_2" id="sent" href="{{url('order')}}">Order</a></li>
                        <li><a class="icon-send_2" id="sent" href="{{url('pending')}}">Pending Orders</a></li>
                        <li><a class="icon-send_2" id="sent" href="{{url('sales')}}">Pending Sales</a></li>
                        <li><a class="icon-send_2" id="sent" href="{{url('sales/individual')}}">Individual Sales</a></li>
                        <li><a class="icon-send_2" id="sent" href="{{url('purchase')}}">Purchase</a></li>
                        <li><a class="icon-send_2" id="sent" href="{{url('print')}}">Print</a></li>
                    </ul>
                </li>

                <li>
                    <a class="nav-cat" href="#uielements" data-toggle="collapse" aria-expanded="false"><img class="parent-icon" src="../images/contact_icon.svg"> Admin Control
                    <span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
                    </a>
                    <ul id="uielements" class="nav nav-second collapse nav-load">
                            <li><a class="icon-people" id="groups" href="{{url('items')}}">Items</a></li>
                            <li><a class="icon-people" id="groups" href="{{url('customers')}}">Customers</a></li>
                            <li><a class="icon-people" id="groups" href="{{url('suppliers')}}">Suppliers</a></li>
                            <li><a class="icon-people" id="groups" href="{{url('drivers')}}">Drivers</a></li>
                            <li><a class="icon-people" id="groups" href="{{url('users')}}">Users</a></li>
                            <!--<li><a class="icon-people" id="manage-group" href="#manage-group">Manage Group</a></li>-->
                            <!-- <li><a  class="icon-person" id="manage-contacts" href="#manage-contacts">Manage Contacts</a></li> -->
<!--                            <li><a class="icon-save" href="">Backup Contacts</a></li>
                            <li><a class="icon-restore" href="">Restore Contacts</a></li>-->
                    </ul>
                </li>


                <li>
                    <a class="nav-cat" href="#tables" data-toggle="collapse" aria-expanded="false"><img class="parent-icon" src="../images/account_circle.svg"> Account
                    <span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
                    </a>
                    <ul id="tables" class="nav nav-second collapse nav-load">
                            <li><a class="icon-credit_card" id="recharge" href="#recharge">Recharge</a></li>
                            <li><a  class="icon-share_alt" id="share-credit" href="#share-credit">Share Credits</a></li>
                            <li><a class="icon-settings" id="settings" href="#settings">Settings</a></li>
                            <li><a class="icon-exit_to_app" id="logout" href="{{url('logout')}}">Logout</a></li>
                    </ul>
                </li>


                <!-- <li>
                    <a class="nav-cat" href="#charts" data-toggle="collapse" aria-expanded="false"><img class="parent-icon" src="../images/help_2.svg"> Help
                    <span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
                    </a>
                    <ul id="charts" class="nav nav-second collapse nav-load">
                            <li><a class="icon-naira_symb_1" id="pricing" href="#">Pricing</a></li>
                            <li><a  class="icon-help" id="how-to" href="#">How to Recharge</a></li>
                            <li><i class="material-icons">print</i><a class="" id="voucher-vendors" href="#">Voucher Vendors</a></li>
                            <li><i class="material-icons">print</i><a class="" id="bank-locator" href="#">Bank Locator</a></li>
                            <li><a class="icon-info" id="leadership" href="#">Leadership</a></li>
                            <li><a class="icon-info" id="about-dart" href="#">About Dart Pro</a></li>
                    </ul>
                </li> -->

            </ul>
        </nav>



    </aside>