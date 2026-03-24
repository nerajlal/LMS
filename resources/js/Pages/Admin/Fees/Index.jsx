import AdminLayout from '@/Layouts/AdminLayout';
import { Head, router } from '@inertiajs/react';

export default function AdminFeesIndex({ fees, stats }) {
    const statusBadge = (status) => {
        const map = { paid: { bg: '#d1fae5', color: '#059669' }, pending: { bg: '#fef3c7', color: '#d97706' }, overdue: { bg: '#fee2e2', color: '#dc2626' } };
        const s = map[status] || { bg: '#F4F4F4', color: '#6b7280' };
        return <span style={{ background: s.bg, color: s.color, borderRadius: '20px', padding: '3px 10px', fontSize: '12px', fontWeight: 600 }}>{status}</span>;
    };

    return (
        <AdminLayout title="Fee Records">
            <Head title="Admin — Fees" />

            {/* Summary cards */}
            <div className="row g-3 mb-4">
                <div className="col-md-6">
                    <div style={{ background: '#fff', borderRadius: '12px', padding: '20px', boxShadow: '0 1px 4px rgba(0,0,0,0.08)', borderTop: '4px solid #10b981' }}>
                        <div style={{ fontSize: '13px', color: '#6b7280', marginBottom: '6px' }}>Total Collected</div>
                        <div style={{ fontSize: '26px', fontWeight: 700, color: '#1f2937' }}>₹{(stats?.total_collected ?? 0).toLocaleString()}</div>
                    </div>
                </div>
                <div className="col-md-6">
                    <div style={{ background: '#fff', borderRadius: '12px', padding: '20px', boxShadow: '0 1px 4px rgba(0,0,0,0.08)', borderTop: '4px solid #ef4444' }}>
                        <div style={{ fontSize: '13px', color: '#6b7280', marginBottom: '6px' }}>Total Due</div>
                        <div style={{ fontSize: '26px', fontWeight: 700, color: '#1f2937' }}>₹{(stats?.total_due ?? 0).toLocaleString()}</div>
                    </div>
                </div>
            </div>

            <div style={{ background: '#fff', borderRadius: '12px', boxShadow: '0 1px 4px rgba(0,0,0,0.08)', overflow: 'hidden' }}>
                <div style={{ overflowX: 'auto' }}>
                    <table style={{ width: '100%', borderCollapse: 'collapse', fontSize: '14px' }}>
                        <thead>
                            <tr style={{ background: '#f9fafb' }}>
                                {['#', 'Student', 'Total Amount', 'Paid', 'Due Date', 'Status', 'Action'].map(h => (
                                    <th key={h} style={{ padding: '12px 16px', textAlign: 'left', fontWeight: 600, color: '#6b7280', fontSize: '12px', textTransform: 'uppercase', letterSpacing: '0.04em', whiteSpace: 'nowrap' }}>{h}</th>
                                ))}
                            </tr>
                        </thead>
                        <tbody>
                            {(fees?.data || []).length === 0 ? (
                                <tr><td colSpan="7" style={{ padding: '32px', textAlign: 'center', color: '#9ca3af' }}>No fee records yet.</td></tr>
                            ) : fees.data.map((fee, i) => (
                                <tr key={fee.id} style={{ borderTop: '1px solid #F4F4F4' }}
                                    onMouseEnter={e => e.currentTarget.style.background = '#fafafa'}
                                    onMouseLeave={e => e.currentTarget.style.background = 'transparent'}
                                >
                                    <td style={{ padding: '12px 16px', color: '#9ca3af', fontSize: '13px' }}>{i + 1}</td>
                                    <td style={{ padding: '12px 16px', fontWeight: 600, color: '#1f2937' }}>{fee.user?.name}</td>
                                    <td style={{ padding: '12px 16px', fontWeight: 600, color: '#1f2937' }}>₹{parseFloat(fee.total_amount).toLocaleString()}</td>
                                    <td style={{ padding: '12px 16px', color: '#10b981', fontWeight: 600 }}>₹{parseFloat(fee.paid_amount || 0).toLocaleString()}</td>
                                    <td style={{ padding: '12px 16px', color: '#6b7280', fontSize: '13px' }}>{fee.due_date ? new Date(fee.due_date).toLocaleDateString() : '—'}</td>
                                    <td style={{ padding: '12px 16px' }}>{statusBadge(fee.status)}</td>
                                    <td style={{ padding: '12px 16px' }}>
                                        {fee.status !== 'paid' ? (
                                            <button onClick={() => router.post(route('admin.fees.markPaid', fee.id))} style={{
                                                background: '#d1fae5', color: '#059669', border: 'none',
                                                padding: '5px 14px', borderRadius: '6px', fontSize: '12px', fontWeight: 600, cursor: 'pointer',
                                            }}>
                                                <i className="bi bi-check-circle me-1"></i>Mark Paid
                                            </button>
                                        ) : (
                                            <span style={{ color: '#9ca3af', fontSize: '13px' }}>—</span>
                                        )}
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            </div>
        </AdminLayout>
    );
}
