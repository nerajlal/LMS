import LmsLayout from '@/Layouts/LmsLayout';
import { Head } from '@inertiajs/react';
import { useState } from 'react';

export default function FeesIndex({ auth, fees }) {
    const allFees = fees || [
        { id: 1, course: 'Full Stack Web Development', total: 12000, paid: 12000, due_date: '2026-01-01', status: 'paid' },
        { id: 2, course: 'Data Science & ML', total: 15000, paid: 7500, due_date: '2026-04-01', status: 'partially_paid' },
    ];

    const totalDue = allFees.reduce((s, f) => s + (f.total - f.paid), 0);
    const totalPaid = allFees.reduce((s, f) => s + f.paid, 0);
    const totalFees = allFees.reduce((s, f) => s + f.total, 0);

    const statusConfig = {
        paid:           { color: '#10b981', bg: '#d1fae5', label: 'Paid' },
        partially_paid: { color: '#f59e0b', bg: '#fef3c7', label: 'Partial' },
        pending:        { color: '#ef4444', bg: '#fee2e2', label: 'Due' },
    };

    const card = { background: '#fff', borderRadius: '8px', boxShadow: '0 1px 3px rgba(0,0,0,0.08)', padding: '20px' };

    return (
        <LmsLayout title="Fee Management">
            <Head title="Fee Management" />

            {/* Summary Cards */}
            <div className="row g-3 mb-4">
                <div className="col-12 col-md-4">
                    <div style={{ ...card, borderTop: '3px solid #3b82f6' }}>
                        <div style={{ color: '#6b7280', fontSize: '13px', marginBottom: '6px' }}>Total Fees</div>
                        <div style={{ color: '#1f2937', fontSize: '24px', fontWeight: 700 }}>₹{totalFees.toLocaleString()}</div>
                    </div>
                </div>
                <div className="col-12 col-md-4">
                    <div style={{ ...card, borderTop: '3px solid #10b981' }}>
                        <div style={{ color: '#6b7280', fontSize: '13px', marginBottom: '6px' }}>Total Paid</div>
                        <div style={{ color: '#10b981', fontSize: '24px', fontWeight: 700 }}>₹{totalPaid.toLocaleString()}</div>
                    </div>
                </div>
                <div className="col-12 col-md-4">
                    <div style={{ ...card, borderTop: '3px solid #ef4444' }}>
                        <div style={{ color: '#6b7280', fontSize: '13px', marginBottom: '6px' }}>Pending Amount</div>
                        <div style={{ color: '#ef4444', fontSize: '24px', fontWeight: 700 }}>₹{totalDue.toLocaleString()}</div>
                    </div>
                </div>
            </div>

            {/* Fee Table */}
            <div style={{ background: '#fff', borderRadius: '8px', boxShadow: '0 1px 3px rgba(0,0,0,0.08)', overflow: 'hidden' }}>
                <div style={{ padding: '16px 20px', borderBottom: '1px solid #f3f4f6', display: 'flex', alignItems: 'center', justifyContent: 'space-between' }}>
                    <h2 style={{ color: '#1f2937', fontSize: '15px', fontWeight: 700, margin: 0 }}>Fee Details</h2>
                    {totalDue > 0 && (
                        <a href={route('payments.create')} style={{ padding: '7px 16px', background: '#2563eb', color: '#fff', borderRadius: '6px', textDecoration: 'none', fontSize: '13px', fontWeight: 600 }}>
                            <i className="bi bi-credit-card me-1"></i> Pay Now
                        </a>
                    )}
                </div>
                <table style={{ width: '100%', borderCollapse: 'collapse' }}>
                    <thead>
                        <tr style={{ background: '#f9fafb' }}>
                            {['Course', 'Total Fee', 'Paid', 'Balance', 'Due Date', 'Status', ''].map(h => (
                                <th key={h} style={{ padding: '12px 20px', textAlign: 'left', color: '#6b7280', fontSize: '11px', fontWeight: 600, textTransform: 'uppercase', letterSpacing: '0.5px', borderBottom: '1px solid #e5e7eb' }}>{h}</th>
                            ))}
                        </tr>
                    </thead>
                    <tbody>
                        {allFees.map((fee, i) => {
                            const s = statusConfig[fee.status] || statusConfig.pending;
                            const balance = fee.total - fee.paid;
                            return (
                                <tr key={fee.id} style={{ borderBottom: i < allFees.length - 1 ? '1px solid #f3f4f6' : 'none' }}
                                    onMouseEnter={e => e.currentTarget.style.background = '#fafafa'}
                                    onMouseLeave={e => e.currentTarget.style.background = ''}
                                >
                                    <td style={{ padding: '14px 20px', color: '#1f2937', fontSize: '14px', fontWeight: 500 }}>{fee.course}</td>
                                    <td style={{ padding: '14px 20px', color: '#374151', fontSize: '13px' }}>₹{fee.total.toLocaleString()}</td>
                                    <td style={{ padding: '14px 20px', color: '#10b981', fontSize: '13px', fontWeight: 600 }}>₹{fee.paid.toLocaleString()}</td>
                                    <td style={{ padding: '14px 20px', color: balance > 0 ? '#ef4444' : '#10b981', fontSize: '13px', fontWeight: 600 }}>₹{balance.toLocaleString()}</td>
                                    <td style={{ padding: '14px 20px', color: '#6b7280', fontSize: '13px' }}>{fee.due_date}</td>
                                    <td style={{ padding: '14px 20px' }}>
                                        <span style={{ padding: '3px 10px', borderRadius: '4px', background: s.bg, color: s.color, fontSize: '12px', fontWeight: 600 }}>{s.label}</span>
                                    </td>
                                    <td style={{ padding: '14px 20px' }}>
                                        {balance > 0 && (
                                            <a href={route('payments.create')} style={{ padding: '5px 12px', background: '#eff6ff', border: '1px solid #bfdbfe', color: '#2563eb', borderRadius: '5px', textDecoration: 'none', fontSize: '12px', fontWeight: 600 }}>
                                                Pay
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
