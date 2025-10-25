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
                <h5 class="mb-3">Current Balance: <span id="currentBalance" class="fw-bold"></span></h5>

                <form id="walletForm">
                    <input type="hidden" id="walletUserId" name="user_id">
                    <div class="row">
                        <div class="col-md-6">
                            <select class="form-select" id="transactionType" name="transaction_type" required>
                                <option value="credit">Credit</option>
                                <option value="debit">Debit</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <div class="form-outline">
                                <input type="number" id="amount" name="amount" class="form-control" min="0.01" step="0.01" required />
                                <label class="form-label" for="amount">Amount</label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Submit Transaction</button>
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
