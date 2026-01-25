@extends('layout.admin_master')

@section('page_title', 'Earnings Management')

@section('content')
    <section class="stats-section">
        <div class="philosophy-container">
            <!-- Summary Cards -->
            <div class="dashboard-stats-grid">
                <!-- Stat Card 1 -->
                <div class="stat-card">
                    <div class="stat-card-icon" style="background: rgba(249, 115, 22, 0.1);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                            <path d="M12 10v6"></path>
                            <path d="M8 10h8"></path>
                        </svg>
                    </div>
                    <div class="stat-number" data-target="{{ $totalEarnings }}">{{ number_format($totalEarnings, 2) }} JOD</div>
                    <div class="stat-label">Total Earnings</div>
                </div>

                <!-- Stat Card 2 -->
                <div class="stat-card">
                    <div class="stat-card-icon" style="background: rgba(249, 115, 22, 0.1);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                        </svg>
                    </div>
                    <div class="stat-number" data-target="{{ $availableToWithdraw }}">{{ number_format($availableToWithdraw, 2) }} JOD</div>
                    <div class="stat-label">Available to Withdraw</div>
                </div>

                <!-- Stat Card 3 -->
                <div class="stat-card">
                    <div class="stat-card-icon" style="background: rgba(249, 115, 22, 0.1);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="17 10 12 15 7 10"></polyline>
                            <line x1="12" y1="15" x2="12" y2="3"></line>
                        </svg>
                    </div>
                    <div class="stat-number" data-target="{{ $platformFees }}">{{ number_format($platformFees, 2) }} JOD</div>
                    <div class="stat-label">Platform Fees</div>
                </div>
            </div>

            <!-- Monthly Earnings Chart -->
            <div class="stat-card" style="padding: 30px;">
                <h2 class="section-title" style="font-size: 24px; color: var(--text-primary); margin-bottom: 20px;">Monthly Earnings</h2>
                <div style="height: 300px; position: relative;">
                    <div style="display: flex; align-items: flex-end; height: 250px; gap: 15px; padding: 20px 0; border-bottom: 1px solid var(--metal-dark);">
                       
                    </div>
                </div>
            </div>

            <!-- Payouts Table -->
            <div class="stat-card">
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 20px; border-bottom: 1px solid var(--metal-dark);">
                    <h2 class="section-title" style="font-size: 24px; color: var(--text-primary);">Payout History</h2>
                    <button class="card-cta">Request Payout</button>
                </div>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Amount</th>
                            <th>Description</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="status-badge status-confirmed">Paid</span></td>
                            <td style="color: var(--accent-cyan);">{{ number_format($monthlyData[now()->month - 1] ?? 0, 2) }} JOD</td>
                            <td>Monthly Payout - {{ now()->format('F Y') }}</td>
                            <td>{{ now()->format('M d, Y') }}</td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        window.addEventListener('load', () => {
            setTimeout(() => {
                const loader = document.getElementById('loader');
                if (loader) loader.classList.add('hidden');
            }, 1000);
        });

       
        function animateCounter(element) {
            const target = parseInt(element.dataset.target.replace(/,/g, ''));
            const duration = 2000;
            const step = target / (duration / 16);
            let current = 0;
            
            const counter = setInterval(() => {
                current += step;
                if (current >= target) {
                    element.textContent = target.toLocaleString();
                    clearInterval(counter);
                } else {
                    element.textContent = Math.floor(current).toLocaleString();
                }
            }, 16);
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.stat-number[data-target]').forEach(animateCounter);
        });
    </script>
@endsection