<!-- Wallet Modal -->
<div class="modal fade" id="walletModal" tabindex="-1" aria-labelledby="walletModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="walletModalLabel">Manage Wallet</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="walletAlerts"></div>
                <div class="mb-3">
                    <h5 class="mb-1">Current Balance: <span id="currentBalance" class="fw-bold text-success"></span></h5>
                    <small id="parentBalance" class="text-muted"></small>
                </div>

                <form id="walletForm">
                    <input type="hidden" id="walletUserId" name="user_id">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="walletCsrf">

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="form-outline">
                                <input type="text" id="productType" name="product_type" class="form-control" required />
                                <label class="form-label" for="productType">Product Type</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <select class="form-select" id="transactionType" name="transaction_type" required>
                                <option value="credit">Credit</option>
                                <option value="debit">Debit</option>
                            </select>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="form-outline">
                                <input type="number" id="amount" name="amount" class="form-control" min="0.01" step="0.01" required />
                                <label class="form-label" for="amount">Amount</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="form-outline">
                                <input type="number" id="rate" name="rate" class="form-control" min="0" step="0.01" required />
                                <label class="form-label" for="rate">Rate</label>
                            </div>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-md-6 mb-4">
                            <select class="form-select" id="paymentStatus" name="payment_status" required>
                                <option value="paid">Paid</option>
                                <option value="not_paid">Not Paid</option>
                                <option value="scheme">Scheme</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="form-outline">
                                <input type="text" id="remark" name="remark" class="form-control" />
                                <label class="form-label" for="remark">Remark</label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Transaction</button>
                </form>

                <hr class="my-4">

                <h5 class="mb-3">Transaction History</h5>
                <table id="transactionHistoryTable" class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Remark</th>
                        </tr>
                    </thead>
                    <tbody id="transactionHistoryBody">
                        <!-- History will be loaded here via AJAX -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
