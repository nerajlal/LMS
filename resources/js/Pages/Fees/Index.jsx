import LmsLayout from '@/Layouts/LmsLayout';
import { Head } from '@inertiajs/react';

export default function FeesIndex({ auth, fees }) {
    const allFees = fees || [
        { id: 1, course: 'Full Stack Web Development', total: 12000, paid: 12000, due_date: '2026-01-01', status: 'paid' },
        { id: 2, course: 'Data Science & ML', total: 15000, paid: 7500, due_date: '2026-04-01', status: 'partially_paid' },
    ];

    const totalDue = allFees.reduce((sum, f) => sum + (f.total - f.paid), 0);

    const statusConfig = {
        paid: { color: '#10b981', bg: '#10b98122', label: 'Paid' },
        partially_paid: { color: '#f59e0b', bg: '#f59e0b22', label: 'Partial' },
        pending: { color: '#ef4444', bg: '#ef444422', label: 'Due' },
    };

    return (
        <LmsLayout>
            <Head title="Fee Management" />
            <div className="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h1 style={{ color: '#fff', fontSize: '24px', fontWeight: 700, margin: 0 }}>Fee Management</h1>
                    <p style={{ color: 'rgba(255,255,255,0.5)', fontSize: '14px', margin: '4px 0 0 0' }}>Track your payments and dues</p>
                </div>
                {totalDue > 0 && (
                    <a href={route('payments.create')} style={{
                        padding: '10px 20px', background: 'linear-gradient(90deg, #7c3aed, #4f46e5)',
                        color: '#fff', borderRadius: '10px', textDecoration: 'none', fontSize: '14px', fontWeight: 600,
                    }}>
                        <i className="bi bi-credit-card me-2"></i> Pay Now
                    </a>
                )}
            </div>

            {/* Summary Cards */}
            <div className="row g-3 mb-4">
                <div className="col-12 col-md-4">
                    <div style={{ background: 'rgba(255,255,255,0.04)', border: '1px solid rgba(255,255,255,0.08)', borderRadius: '14px', padding: '20px' }}>
                        <div style={{ color: 'rgba(255,255,255,0.5)', fontSize: '13px', marginBottom: '8px' }}>Total Fees</div>
                        <div style={{ color: '#fff', fontSize: '26px', fontWeight: 700 }}>₹{allFees.reduce((s, f) => s + f.total, 0).toLocaleString()}</div>
                    </div>
                </div>
                <div className="col-12 col-md-4">
                    <div style={{ background: 'rgba(16,185,129,0.08)', border: '1px solid rgba(16,185,129,0.2)', borderRadius: '14px', padding: '20px' }}>
                        <div style={{ color: 'rgba(255,255,255,0.5)', fontSize: '13px', marginBottom: '8px' }}>Total Paid</div>
                        <div style={{ color: '#10b981', fontSize: '26px', fontWeight: 700 }}>₹{allFees.reduce((s, f) => s + f.paid, 0).toLocaleString()}</div>
                    </div>
                </div>
                <div className="col-12 col-md-4">
                    <div style={{ background: 'rgba(239,68,68,0.08)', border: '1px solid rgba(239,68,68,0.2)', borderRadius: '14px', padding: '20px' }}>
                        <div style={{ color: 'rgba(255,255,255,0.5)', fontSize: '13px', marginBottom: '8px' }}>Pending Amount</div>
                        <div style={{ color: '#ef4444', fontSize: '26px', fontWeight: 700 }}>₹{totalDue.toLocaleString()}</div>
                    </div>
                </div>
            </div>

            {/* Fee Table */}
            <div style={{ background: 'rgba(255,255,255,0.04)', border: '1px solid rgba(255,255,255,0.08)', borderRadius: '16px', overflow: 'hidden' }}>
                <table style={{ width: '100%', borderCollapse: 'collapse' }}>
                    <thead>
                        <tr style={{ background: 'rgba(255,255,255,0.04)' }}>
                            {['Course', 'Total Fee', 'Paid', 'Balance', 'Due Date', 'Status', 'Action'].map(h => (
                                <th key={h} style={{ padding: '14px 20px', textAlign: 'left', color: 'rgba(255,255,255,0.5)', fontSize: '11px', fontWeight: 600, textTransform: 'uppercase', letterSpacing: '0.5px', borderBottom: '1px solid rgba(255,255,255,0.06)' }}>{h}</th>
                            ))}
                        </tr>
                    </thead>
                    <tbody>
                        {allFees.map(fee => {
                            const s = statusConfig[fee.status] || statusConfig.pending;
                            const balance = fee.total - fee.paid;
                            return (
                                <tr key={fee.id} style={{ borderBottom: '1px solid rgba(255,255,255,0.06)' }}>
                                    <td style={{ padding: '16px 20px', color: '#fff', fontSize: '14px', fontWeight: 500 }}>{fee.course}</td>
                                    <td style={{ padding: '16px 20px', color: 'rgba(255,255,255,0.7)', fontSize: '14px' }}>₹{fee.total.toLocaleString()}</td>
                                    <td style={{ padding: '16px 20px', color: '#10b981', fontSize: '14px' }}>₹{fee.paid.toLocaleString()}</td>
                                    <td style={{ padding: '16px 20px', color: balance > 0 ? '#ef4444' : '#10b981', fontSize: '14px', fontWeight: 600 }}>₹{balance.toLocaleString()}</td>
                                    <td style={{ padding: '16px 20px', color: 'rgba(255,255,255,0.5)', fontSize: '13px' }}>{fee.due_date}</td>
                                    <td style={{ padding: '16px 20px' }}>
                                        <span style={{ padding: '4px 10px', borderRadius: '100px', background: s.bg, color: s.color, fontSize: '12px', fontWeight: 600 }}>{s.label}</span>
                                    </td>
                                    <td style={{ padding: '16px 20px' }}>
                                        {balance > 0 && (
                                            <a href={route('payments.create')} style={{ padding: '6px 14px', background: 'linear-gradient(90deg, #7c3aed, #4f46e5)', color: '#fff', borderRadius: '8px', textDecoration: 'none', fontSize: '12px', fontWeight: 600 }}>
                                                Pay ₹{balance.toLocaleString()}
                                            </a>
                                        )}
                                    </td>
                                </tr>
                            );
                        })}
                    </tbody>
                </table>
            </div>
        </LmsLayout>
    );
}
