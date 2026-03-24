import AdminLayout from '@/Layouts/AdminLayout';
import { Head, Link } from '@inertiajs/react';

export default function AdminTrainersIndex({ trainers, flash }) {
    return (
        <AdminLayout title="Trainers">
            <Head title="Admin — Trainers" />

            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'flex-start', marginBottom: '20px' }}>
                <div>
                    <h1 style={{ margin: 0, fontSize: '20px', fontWeight: 700, color: '#1f2937' }}>All Trainers</h1>
                    <p style={{ margin: '2px 0 0', color: '#6b7280', fontSize: '14px' }}>{trainers?.total ?? 0} registered trainers</p>
                </div>
                <Link
                    href={route('admin.trainers.create')}
                    style={{
                        background: 'linear-gradient(to right, #F37021, #1B365D)',
                        color: '#fff', padding: '10px 20px', borderRadius: '8px',
                        textDecoration: 'none', fontSize: '14px', fontWeight: 600,
                        boxShadow: '0 4px 6px -1px rgba(243,112,33,0.2)'
                    }}
                >
                    <i className="bi bi-plus-circle me-2"></i> Add Trainer
                </Link>
            </div>

            {flash?.success && (
                <div style={{ background: '#ecfdf5', color: '#065f46', padding: '12px 16px', borderRadius: '8px', marginBottom: '20px', display: 'flex', alignItems: 'center', gap: '8px' }}>
                    <i className="bi bi-check-circle-fill"></i> {flash.success}
                </div>
            )}

            <div style={{ background: '#fff', borderRadius: '12px', boxShadow: '0 1px 4px rgba(0,0,0,0.08)', overflow: 'hidden' }}>
                <div style={{ overflowX: 'auto' }}>
                    <table style={{ width: '100%', borderCollapse: 'collapse', fontSize: '14px' }}>
                        <thead>
                            <tr style={{ background: '#F4F4F4' }}>
                                {['#', 'Name', 'Email', 'Assigned Courses', 'Joined'].map(h => (
                                    <th key={h} style={{ padding: '12px 16px', textAlign: 'left', fontWeight: 600, color: '#6b7280', fontSize: '12px', textTransform: 'uppercase', letterSpacing: '0.04em', whiteSpace: 'nowrap' }}>{h}</th>
                                ))}
                            </tr>
                        </thead>
                        <tbody>
                            {(trainers?.data || []).length === 0 ? (
                                <tr><td colSpan="5" style={{ padding: '32px', textAlign: 'center', color: '#9ca3af' }}>
                                    No trainers registered yet. Create one above.
                                </td></tr>
                            ) : trainers.data.map((trainer, i) => (
                                <tr key={trainer.id} style={{ borderTop: '1px solid #F4F4F4' }}
                                    onMouseEnter={e => e.currentTarget.style.background = '#fafafa'}
                                    onMouseLeave={e => e.currentTarget.style.background = 'transparent'}
                                >
                                    <td style={{ padding: '12px 16px', color: '#9ca3af', fontSize: '13px' }}>{i + 1}</td>
                                    <td style={{ padding: '12px 16px' }}>
                                        <div style={{ display: 'flex', alignItems: 'center', gap: '10px' }}>
                                            <div style={{
                                                width: '34px', height: '34px', borderRadius: '50%', flexShrink: 0,
                                                background: 'linear-gradient(135deg, #1B365D, #F37021)',
                                                display: 'flex', alignItems: 'center', justifyContent: 'center',
                                                color: '#fff', fontWeight: 700, fontSize: '13px',
                                            }}>
                                                {trainer.name?.charAt(0).toUpperCase()}
                                            </div>
                                            <span style={{ fontWeight: 600, color: '#1f2937' }}>{trainer.name}</span>
                                        </div>
                                    </td>
                                    <td style={{ padding: '12px 16px', color: '#6b7280' }}>{trainer.email}</td>
                                    <td style={{ padding: '12px 16px', color: '#6b7280' }}>
                                        <span style={{ background: '#eff6ff', color: '#2563eb', borderRadius: '20px', padding: '2px 10px', fontSize: '12px', fontWeight: 600 }}>
                                            {trainer.courses_count ?? 0}
                                        </span>
                                    </td>
                                    <td style={{ padding: '12px 16px', color: '#9ca3af', fontSize: '13px' }}>
                                        {new Date(trainer.created_at).toLocaleDateString()}
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
