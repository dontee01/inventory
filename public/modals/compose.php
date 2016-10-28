<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content bbn-modal">
                    <form method="post" id="compose-modal">
                        <div class="modal-header text-left">
                            <div class="text-right">
                                <button class="glyphicon glyphicon-remove" data-dismiss="modal" style="border:0px;"></button>
                            </div>
                            <div class="text-left">
                                <h4 class="modal-title">Compose Message</h4>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="row modal-row">

                    <div class="panel-body">
                        <div class="">
                            <div class=form-group>
                             <input class="form-control" type="text" name="sender" id="compose-sender" placeholder="Sender Name" />
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="">
                            <div class=form-group>
                                <label class=" pull-right">
                                    <a class="" id="contact-add" data-dismiss="modal" data-toggle="modal" data-target="#contactModal">
                                        <i class="icon-person"></i></a>
                                </label>
                                <textarea class="form-control" name="number" id="compose-number" placeholder="Enter Numbers or Add from Contacts"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="">
                            <div class=form-group>
                                <label></label>
                                <textarea class="form-control" name="message" id="compose-message" rows="3" placeholder="Enter your message"></textarea>
                            </div>
                        </div>
                    </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
                            <button type="button" class="btn btn-modal-save pull-left" 
                                    id="compose-save" data-dismiss="modal" >Save</button>
                            <button type="button" class="btn btn-danger btn-recharge" 
                                    id="compose-send" data-dismiss="modal">Send</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>