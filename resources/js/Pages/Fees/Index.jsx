import LmsLayout from '@/Layouts/LmsLayout';
import { Head, Link } from '@inertiajs/react';

const cardStyle = {
    background: '#fff',
    borderRadius: '16px',
    boxShadow: '0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03)',
    padding: '24px',
    border: '1px solid #f1f5f9',
};

const statusConfig = {
    paid:           { color: '#10b981', bg: '#ecfdf5', label: 'Paid', icon: 'bi-check-circle-fill' },
    partially_paid: { color: '#f59e0b', bg: '#fffbeb', label: 'Partial', icon: 'bi-dash-circle-fill' },
    pending:        { color: '#ef4444', bg: '#fef2f2', label: 'Due', icon: 'bi-exclamation-circle-fill' },
};

export default function FeesIndex({ auth, fees }) {
    const allFees = fees || [];

    const totalDue = allFees.reduce((s, f) => s + (f.total_amount - f.paid_amount), 0);
    const totalPaid = allFees.reduce((s, f) => s + f.paid_amount, 0);
    const totalFees = allFees.reduce((s, f) => s + f.total_amount, 0);

    return (
        <LmsLayout title="Payments & Fees">
            <Head title="My Fees - EduLMS" />

            <div style={{ marginBottom: '32px' }}>
                <h2 style={{ fontSize: '24px', fontWeight: 800, color: '#1e293b', marginBottom: '8px' }}>Financial Overview</h2>
                <p style={{ fontSize: '15px', color: '#64748b' }}>Manage your course fees and view payment history.</p>
            </div>

            {/* Summary Row */}
            <div className="row g-4 mb-5">
                <div className="col-md-4">
                    <div style={{ ...cardStyle, background: 'linear-gradient(135deg, #cc0000 0%, #e3000f 100%)', color: '#fff', border: 'none' }}>
                        <div style={{ fontSize: '13px', fontWeight: 700, opacity: 0.8, textTransform: 'uppercase', letterSpacing: '0.05em', marginBottom: '12px' }}>Total Course Fee</div>
                        <div style={{ fontSize: '32px', fontWeight: 900 }}>₹{totalFees.toLocaleString()}</div>
                        <div style={{ marginTop: '16px', fontSize: '12px', background: 'rgba(255,255,255,0.1)', padding: '6px 12px', borderRadius: '8px', display: 'inline-block' }}>
                            Across all enrolled courses
                        </div>
                    </div>
                </div>
                <div className="col-md-4">
                    <div style={cardStyle}>
                        <div style={{ fontSize: '13px', fontWeight: 700, color: '#64748b', textTransform: 'uppercase', letterSpacing: '0.05em', marginBottom: '12px' }}>Amount Paid</div>
                        <div style={{ fontSize: '32px', fontWeight: 900, color: '#10b981' }}>₹{totalPaid.toLocaleString()}</div>
                        <div style={{ display: 'flex', alignItems: 'center', gap: '8px', marginTop: '16px' }}>
                            <div style={{ flex: 1, height: '6px', background: '#f1f5f9', borderRadius: '3px', overflow: 'hidden' }}>
                                <div style={{ width: `${(totalPaid/totalFees)*100}%`, height: '100%', background: '#10b981' }}></div>
                            </div>
                            <span style={{ fontSize: '12px', fontWeight: 700, color: '#64748b' }}>{Math.round((totalPaid/totalFees)*100 || 0)}%</span>
                        </div>
                    </div>
                </div>
                <div className="col-md-4">
                    <div style={cardStyle}>
                        <div style={{ fontSize: '13px', fontWeight: 700, color: '#64748b', textTransform: 'uppercase', letterSpacing: '0.05em', marginBottom: '12px' }}>Outstanding Due</div>
                        <div style={{ fontSize: '32px', fontWeight: 900, color: '#ef4444' }}>₹{totalDue.toLocaleString()}</div>
                        {totalDue > 0 && (
                            <Link href={route('payments.create')} style={{ display: 'inline-flex', alignItems: 'center', gap: '8px', marginTop: '16px', color: '#e3000f', fontWeight: 700, fontSize: '12px', textDecoration: 'none' }}>
                                Pay Now <i className="bi bi-arrow-right"></i>
                            </Link>
                        )}
                    </div>
                </div>
            </div>

            {/* Detailed Table */}
            <div style={cardStyle}>
                <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', marginBottom: '24px' }}>
                    <h3 style={{ fontSize: '18px', fontWeight: 800, color: '#1e293b', margin: 0 }}>Fee Breakdown</h3>
                    {totalDue > 0 && (
                        <Link href={route('payments.create')} style={{ padding: '10px 20px', background: '#e3000f', color: '#fff', borderRadius: '10px', textDecoration: 'none', fontSize: '13px', fontWeight: 700, boxShadow: '0 4px 12px rgba(37, 99, 235, 0.2)' }}>
                            <i className="bi bi-credit-card-2-front me-2"></i> Make a Payment
                        </Link>
                    )}
                </div>

                <div className="table-responsive">
                    <table className="table table-hover align-middle" style={{ margin: 0 }}>
                        <thead style={{ borderBottom: '2px solid #f1f5f9' }}>
                            <tr>
                                <th style={{ padding: '16px', fontSize: '12px', fontWeight: 700, color: '#64748b', textTransform: 'uppercase' }}>Course Name</th>
                                <th style={{ padding: '16px', fontSize: '12px', fontWeight: 700, color: '#64748b', textTransform: 'uppercase' }}>Total Fee</th>
                                <th style={{ padding: '16px', fontSize: '12px', fontWeight: 700, color: '#64748b', textTransform: 'uppercase' }}>Paid</th>
                                <th style={{ padding: '16px', fontSize: '12px', fontWeight: 700, color: '#64748b', textTransform: 'uppercase' }}>Balance</th>
                                <th style={{ padding: '16px', fontSize: '12px', fontWeight: 700, color: '#64748b', textTransform: 'uppercase' }}>Status</th>
                                <th style={{ padding: '16px', fontSize: '12px', fontWeight: 700, color: '#64748b', textTransform: 'uppercase' }}>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {allFees.length === 0 ? (
                                <tr>
                                    <td colSpan="6" style={{ padding: '48px', textAlign: 'center', color: '#64748b' }}>
                                        <i className="bi bi-receipt mb-3" style={{ fontSize: '40px', opacity: 0.2, display: 'block' }}></i>
                                        No fee records found.
                                    </td>
                                </tr>
                            ) : allFees.map((fee) => {
                                const s = statusConfig[fee.status] || statusConfig.pending;
                                const balance = fee.total_amount - fee.paid_amount;
                                return (
                                    <tr key={fee.id}>
                                        <td style={{ padding: '20px 16px' }}>
                                            <div style={{ fontWeight: 700, color: '#1e293b' }}>{fee.course?.title || 'Unknown Course'}</div>
                                            <div style={{ fontSize: '12px', color: '#94a3b8' }}>ID: #{fee.id.toString().padStart(5, '0')}</div>
                                        </td>
                                        <td style={{ padding: '20px 16px', fontSize: '14px', fontWeight: 600, color: '#1e293b' }}>₹{fee.total_amount.toLocaleString()}</td>
                                        <td style={{ padding: '20px 16px', fontSize: '14px', fontWeight: 700, color: '#10b981' }}>₹{fee.paid_amount.toLocaleString()}</td>
                                        <td style={{ padding: '20px 16px', fontSize: '14px', fontWeight: 700, color: balance > 0 ? '#ef4444' : '#10b981' }}>₹{balance.toLocaleString()}</td>
                                        <td style={{ padding: '20px 16px' }}>
                                            <div style={{ display: 'inline-flex', alignItems: 'center', gap: '6px', padding: '6px 14px', borderRadius: '30px', background: s.bg, color: s.color, fontSize: '12px', fontWeight: 700 }}>
                                                <i className={`bi ${s.icon}`}></i>
                                                {s.label}
                                            </div>
                                        </td>
                                        <td style={{ padding: '20px 16px' }}>
                                            {balance > 0 ? (
                                                <Link href={route('payments.create')} style={{ padding: '8px 16px', background: '#eff6ff', border: '1px solid #dbeafe', color: '#e3000f', borderRadius: '8px', textDecoration: 'none', fontSize: '12px', fontWeight: 700 }}>
                                                    Pay
                                                </Link>
                                            ) : (
                                                <Link style={{ padding: '8px 16px', background: '#f8fafc', border: '1px solid #f1f5f9', color: '#94a3b8', borderRadius: '8px', textDecoration: 'none', fontSize: '12px', fontWeight: 700, cursor: 'default' }}>
                                                    Paid
                                                </Link>
                                            )}
                                        </td>
                                    </tr>
                                );
                            })}
                        </tbody>
                    </table>
                </div>
            </div>

            {/* Info Section */}
            <div className="mt-5" style={{ ...cardStyle, background: '#f8fafc', borderStyle: 'dashed' }}>
                <div style={{ display: 'flex', gap: '16px' }}>
                    <div style={{ fontSize: '24px', color: '#e3000f' }}><i className="bi bi-info-circle-fill"></i></div>
                    <div>
                        <h4 style={{ fontSize: '15px', fontWeight: 800, color: '#1e293b', marginBottom: '4px' }}>Secure Payments with PhonePe</h4>
                        <p style={{ fontSize: '13px', color: '#64748b', margin: 0, lineHeight: '1.6' }}>
                            All transactions are encrypted and processed securely. Once payment is successful, your course status and materials will be automatically updated. 
                            For any issues, please contact student support with your transaction ID.
                        </p>
                    </div>
                </div>
            </div>
        </LmsLayout>
    );
}
