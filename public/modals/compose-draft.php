<div class="modal fade" id="editDraftModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content bbn-modal">
                    <form method="post" id="compose-modal">
                        <div class="modal-header text-left">
                            <div class="text-right">
                                <button class="glyphicon glyphicon-remove" data-dismiss="modal" style="border:0px;"></button>
                            </div>
                            <div class="text-left">
                                <h4 class="modal-title">Edit Draft</h4>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="row modal-row">

                    <div class="panel-body">
                        <div class="">
                            <div class=form-group>
                             <input class="form-control" type="text" name="sender" id="compose-draft-sender" placeholder="Sender Name" />
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="">
                            <div class=form-group>
                                <label class=" pull-right">
                                    <a class="" id="contact-draft-add" data-dismiss="modal" data-toggle="modal" data-target="#contactDraftModal">
                                        <i class="icon-person"></i></a>
                                </label>
                                <textarea class="form-control" name="number" id="compose-draft-number" placeholder="Enter Numbers or Add from Contacts"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="">
                            <div class=form-group>
                                <label></label>
                                <textarea class="form-control" name="message" id="compose-draft-message" rows="3" placeholder="Enter your message"></textarea>
                            </div>
                        </div>
                    </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
                            <button type="button" class="btn btn-modal-save pull-left" 
                                    id="compose-draft-save" data-dismiss="modal" >Save</button>
                            <button type="button" class="btn btn-danger btn-recharge" 
                                    id="compose-draft-send" data-dismiss="modal">Send</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>