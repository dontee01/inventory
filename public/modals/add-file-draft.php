            <div class="modal fade" id="contactDraftModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content bbn-modal">
                        <input type="hidden" id="contact-arr" value="" />
                    <!--<form method="post" id="compose-modal">-->
                        <div class="modal-header text-left">
                            <div class="text-right">
                                <button class="glyphicon glyphicon-remove" data-dismiss="modal" data-toggle="modal" data-target="#myModal" style="border:0px;"></button>
                            </div>
                            <div class="text-left">
                                <h4 class="modal-title">Add Contacts from File</h4>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                                    
    <div class="col-md-12 recharge-header">
        
    <div class="col-lg-12">
        <div class="tabs-container">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#tab-1" aria-expanded="true"> All</a></li>
                <li class=""><a data-toggle="tab" href="#tab-2" aria-expanded="false">Groups</a></li>
                <li class=""><a data-toggle="tab" href="#tab-3" aria-expanded="false">File</a></li>
            </ul>
            <div class="tab-content">
                <div id="tab-1" class="tab-pane active">
                    <div class="panel-body">
                       
                <div class="row ">
<div class="col-md-12 contact-header"></div>
<div class="col-md-5 contact-header">
    <input class="col-md-12 input-md " type="search" name="sch-rcp" id="sch-rcp" placeholder="Search by Name" />
</div>

<div class="col-md-7 dashboard-header text-right">
<span class="contact-menu">
                                    <i class="material-icons">check_circle</i><a class="" href=""></a>Select All
</span>
    <span class="contact-menu">
                                    <i class="material-icons">account_circle</i><a href=""></a>Add Contact
    </span>
</div>
                </div>

    <div class="row">

        
<ul class="msg-list" id="msg-list-add-file-draft">


</ul>
<div class="hypermedia pull-right" id="hypermedia-drafts-edit-contacts">
</div>
        
        </div>
                    </div>
                    <!--voucher tab content ends-->
                </div>
                <div id="tab-2" class="tab-pane">
                    <div class="panel-body">
                           
                    <!--<div class="col-md-12 credit-header-label">Select Bank</div>-->

    <div class="row">
                    <div class="col-md-12 contact-header"></div>
<!--<div class="col-md-12 credit-header">
 
<ul class="credit-list">
    <li>
        <select name="bank" id="bank" class="col-md-12 input-lg " style="border-bottom: 1px solid">
                <option>GT Bank</option>
                <option>First Bank</option>
                <option>Skye Bank</option>
                <option>Eco Bank</option>
                <option>Sterling Bank</option>
        </select>
    </li>
    
<li>
    <input class="col-md-12 input-lg " type="text" name="slipno" id="slipno" placeholder="Enter Slip Number"/>
</li>
    
</ul>

        <div class="credit-bottom text-center">
            <button id="recharge" class="btn btn-lg btn-danger btn-recharge">RECHARGE</button>
        </div>

</div>-->
        </div>
                    </div>
                </div>
                <div id="tab-3" class="tab-pane">
                    <div class="panel-body">
                        <div class="col-md-12 text-center details msg-list">
                            <div>Browse to Select File <br /><br />
                            Formats Accepted:
                            </div>
                            <span class="dash-foot-exec">Excel .txt .doc</span>
                            <br /><br />
                            <button class="btn btn-lg btn-danger btn-recharge text-center">BROWSE FILE</button>
                            <!--<input style="display: inline-block" class="input-lg btn btn-danger btn-recharge" type="file" />-->
                        </div>
                    </div>
                </div>
                

                
            </div>


        </div>
    </div>

    </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
                            <button type="button" class="btn btn-modal-save pull-left" data-dismiss="modal" data-toggle="modal" data-target="#editDraftModal" >CANCEL</button>
                            <button type="button" id="draft-add-file-proceed" data-dismiss="modal" data-toggle="modal" data-target="#editDraftModal" class="btn btn-danger btn-recharge">PROCEED</button>
                        </div>
                    <!--</form>-->
                    </div>
                </div>
            </div>