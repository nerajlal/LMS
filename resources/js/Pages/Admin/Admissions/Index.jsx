import AdminLayout from '@/Layouts/AdminLayout';
import { Head, router } from '@inertiajs/react';

export default function AdminAdmissionsIndex({ admissions }) {
    const statusBadge = (status) => {
        const map = {
            pending:  { bg: '#fef3c7', color: '#d97706' },
            approved: { bg: '#d1fae5', color: '#059669' },
            rejected: { bg: '#fee2e2', color: '#dc2626' },
        };
        const s = map[status] || { bg: '#F4F4F4', color: '#6b7280' };
        return (
            <span style={{ background: s.bg, color: s.color, borderRadius: '20px', padding: '3px 10px', fontSize: '12px', fontWeight: 600 }}>
                {status?.charAt(0).toUpperCase() + status?.slice(1)}
            </span>
        );
    };

    const handleApprove = (id) => router.post(route('admin.admissions.approve', id));
    const handleReject  = (id) => router.post(route('admin.admissions.reject', id));

    return (
        <AdminLayout title="Admissions">
            <Head title="Admin — Admissions" />

            <div style={{ marginBottom: '20px' }}>
                <h1 style={{ margin: 0, fontSize: '20px', fontWeight: 700, color: '#1f2937' }}>Admissions</h1>
                <p style={{ margin: '2px 0 0', color: '#6b7280', fontSize: '14px' }}>{admissions?.total ?? 0} total applications</p>
            </div>

            <div style={{ background: '#fff', borderRadius: '12px', boxShadow: '0 1px 4px rgba(0,0,0,0.08)', overflow: 'hidden' }}>
                <div style={{ overflowX: 'auto' }}>
                    <table style={{ width: '100%', borderCollapse: 'collapse', fontSize: '14px' }}>
                        <thead>
                            <tr style={{ background: '#f9fafb' }}>
                                {['#', 'Student', 'Course', 'Batch', 'Applied', 'Status', 'Actions'].map(h => (
                                    <th key={h} style={{ padding: '12px 16px', textAlign: 'left', fontWeight: 600, color: '#6b7280', fontSize: '12px', textTransform: 'uppercase', letterSpacing: '0.04em', whiteSpace: 'nowrap' }}>{h}</th>
                                ))}
                            </tr>
                        </thead>
                        <tbody>
                            {(admissions?.data || []).length === 0 ? (
                                <tr><td colSpan="7" style={{ padding: '32px', textAlign: 'center', color: '#9ca3af' }}>
                                    No admissions yet.
                                </td></tr>
                            ) : admissions.data.map((a, i) => (
                                <tr key={a.id} style={{ borderTop: '1px solid #F4F4F4' }}
                                    onMouseEnter={e => e.currentTarget.style.background = '#fafafa'}
                                    onMouseLeave={e => e.currentTarget.style.background = 'transparent'}
                                >
                                    <td style={{ padding: '12px 16px', color: '#9ca3af', fontSize: '13px' }}>{i + 1}</td>
                                    <td style={{ padding: '12px 16px', fontWeight: 600, color: '#1f2937' }}>{a.user?.name}</td>
                                    <td style={{ padding: '12px 16px', color: '#6b7280' }}>{a.course?.title}</td>
                                    <td style={{ padding: '12px 16px', color: '#6b7280' }}>{a.batch?.name ?? '—'}</td>
                                    <td style={{ padding: '12px 16px', color: '#9ca3af', fontSize: '13px' }}>{new Date(a.created_at).toLocaleDateString()}</td>
                                    <td style={{ padding: '12px 16px' }}>{statusBadge(a.status)}</td>
                                    <td style={{ padding: '12px 16px' }}>
                                        {a.status === 'pending' ? (
                                            <div style={{ display: 'flex', gap: '6px' }}>
                                                <button onClick={() => handleApprove(a.id)} style={{
                                                    background: '#d1fae5', color: '#059669', border: 'none',
                                                    padding: '5px 12px', borderRadius: '6px', fontSize: '12px', fontWeight: 600, cursor: 'pointer',
                                                }}>
                                                    <i className="bi bi-check-lg me-1"></i>Approve
                                                </button>
                                                <button onClick={() => handleReject(a.id)} style={{
                                                    background: '#fee2e2', color: '#dc2626', border: 'none',
                                                    padding: '5px 12px', borderRadius: '6px', fontSize: '12px', fontWeight: 600, cursor: 'pointer',
                                                }}>
                                                    <i className="bi bi-x-lg me-1"></i>Reject
                                                </button>
                                            </div>
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
