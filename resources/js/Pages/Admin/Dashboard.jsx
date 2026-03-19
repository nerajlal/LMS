import AdminLayout from '@/Layouts/AdminLayout';
import { Head, Link } from '@inertiajs/react';

const StatCard = ({ icon, label, value, color, sub }) => (
    <div style={{
        background: '#fff', borderRadius: '12px', padding: '20px',
        boxShadow: '0 1px 4px rgba(0,0,0,0.08)', borderTop: `4px solid ${color}`,
    }}>
        <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', marginBottom: '12px' }}>
            <div style={{ fontSize: '13px', fontWeight: 500, color: '#6b7280' }}>{label}</div>
            <div style={{
                width: '40px', height: '40px', borderRadius: '10px',
                background: `${color}18`, display: 'flex', alignItems: 'center', justifyContent: 'center',
            }}>
                <i className={`bi ${icon}`} style={{ color, fontSize: '18px' }}></i>
            </div>
        </div>
        <div style={{ fontSize: '28px', fontWeight: 700, color: '#1f2937' }}>{value}</div>
        {sub && <div style={{ fontSize: '12px', color: '#9ca3af', marginTop: '4px' }}>{sub}</div>}
    </div>
);

export default function AdminDashboard({ stats, recentAdmissions }) {
    const statusBadge = (status) => {
        const map = {
            pending:  { bg: '#fef3c7', color: '#d97706' },
            approved: { bg: '#d1fae5', color: '#059669' },
            rejected: { bg: '#fee2e2', color: '#dc2626' },
        };
        const s = map[status] || { bg: '#f3f4f6', color: '#6b7280' };
        return (
            <span style={{ background: s.bg, color: s.color, borderRadius: '20px', padding: '3px 10px', fontSize: '12px', fontWeight: 600 }}>
                {status}
            </span>
        );
    };

    return (
        <AdminLayout title="Dashboard">
            <Head title="Admin Dashboard" />

            {/* Welcome strip */}
            <div style={{
                background: 'linear-gradient(135deg, #7c3aed, #4f46e5)', borderRadius: '14px',
                padding: '24px 28px', marginBottom: '24px', color: '#fff',
            }}>
                <h1 style={{ margin: 0, fontSize: '22px', fontWeight: 700 }}>Admin Dashboard</h1>
                <p style={{ margin: '4px 0 0 0', opacity: 0.75, fontSize: '14px' }}>Welcome back! Here's what's happening in EduLMS.</p>
            </div>

            {/* Stats Grid */}
            <div className="row g-3 mb-4">
                <div className="col-6 col-lg-3">
                    <StatCard icon="bi-people" label="Total Students" value={stats?.total_students ?? 0} color="#3b82f6" />
                </div>
                <div className="col-6 col-lg-3">
                    <StatCard icon="bi-collection-play" label="Total Courses" value={stats?.total_courses ?? 0} color="#7c3aed" />
                </div>
                <div className="col-6 col-lg-3">
                    <StatCard icon="bi-person-check" label="Admissions" value={stats?.total_admissions ?? 0} color="#10b981" sub={`${stats?.pending_admissions ?? 0} pending`} />
                </div>
                <div className="col-6 col-lg-3">
                    <StatCard icon="bi-cash-coin" label="Total Revenue" value={`₹${(stats?.total_revenue ?? 0).toLocaleString()}`} color="#f59e0b" />
                </div>
            </div>

            {/* Quick Actions */}
            <div className="row g-3 mb-4">
                {[
                    { label: 'Add New Course', icon: 'bi-plus-circle', href: route('admin.courses.create'), color: '#7c3aed' },
                    { label: 'View Students',  icon: 'bi-people',       href: route('admin.students.index'), color: '#3b82f6' },
                    { label: 'Manage Admissions', icon: 'bi-person-check', href: route('admin.admissions.index'), color: '#10b981' },
                    { label: 'Fee Records',   icon: 'bi-cash-stack',   href: route('admin.fees.index'), color: '#f59e0b' },
                ].map(a => (
                    <div key={a.label} className="col-6 col-lg-3">
                        <Link href={a.href} style={{
                            display: 'flex', alignItems: 'center', gap: '12px',
                            background: '#fff', borderRadius: '10px', padding: '16px',
                            textDecoration: 'none', color: '#1f2937',
                            boxShadow: '0 1px 4px rgba(0,0,0,0.06)', border: '1px solid #e5e7eb',
                            transition: 'all 0.2s',
                        }}
                            onMouseEnter={e => { e.currentTarget.style.boxShadow = '0 4px 12px rgba(0,0,0,0.1)'; e.currentTarget.style.transform = 'translateY(-2px)'; }}
                            onMouseLeave={e => { e.currentTarget.style.boxShadow = '0 1px 4px rgba(0,0,0,0.06)'; e.currentTarget.style.transform = 'translateY(0)'; }}
                        >
                            <div style={{ width: '38px', height: '38px', borderRadius: '10px', background: `${a.color}18`, display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
                                <i className={`bi ${a.icon}`} style={{ color: a.color, fontSize: '18px' }}></i>
                            </div>
                            <span style={{ fontWeight: 600, fontSize: '14px' }}>{a.label}</span>
                        </Link>
                    </div>
                ))}
            </div>

            {/* Recent Admissions */}
            <div style={{ background: '#fff', borderRadius: '12px', boxShadow: '0 1px 4px rgba(0,0,0,0.08)', overflow: 'hidden' }}>
                <div style={{ padding: '16px 20px', borderBottom: '1px solid #f3f4f6', display: 'flex', alignItems: 'center', justifyContent: 'space-between' }}>
                    <h2 style={{ margin: 0, fontSize: '16px', fontWeight: 700, color: '#1f2937' }}>Recent Admissions</h2>
                    <Link href={route('admin.admissions.index')} style={{ fontSize: '13px', color: '#7c3aed', textDecoration: 'none' }}>View All →</Link>
                </div>
                <div style={{ overflowX: 'auto' }}>
                    <table style={{ width: '100%', borderCollapse: 'collapse', fontSize: '14px' }}>
                        <thead>
                            <tr style={{ background: '#f9fafb' }}>
                                {['Student', 'Course', 'Date', 'Status'].map(h => (
                                    <th key={h} style={{ padding: '10px 16px', textAlign: 'left', fontWeight: 600, color: '#6b7280', fontSize: '12px', textTransform: 'uppercase', letterSpacing: '0.04em' }}>{h}</th>
                                ))}
                            </tr>
                        </thead>
                        <tbody>
                            {(recentAdmissions || []).length === 0 ? (
                                <tr><td colSpan="4" style={{ padding: '24px', textAlign: 'center', color: '#9ca3af' }}>No admissions yet. Seed demo data to populate.</td></tr>
                            ) : (
                                recentAdmissions.map(a => (
                                    <tr key={a.id} style={{ borderTop: '1px solid #f3f4f6' }}>
                                        <td style={{ padding: '12px 16px', color: '#1f2937', fontWeight: 500 }}>{a.user?.name}</td>
                                        <td style={{ padding: '12px 16px', color: '#6b7280' }}>{a.course?.title}</td>
                                        <td style={{ padding: '12px 16px', color: '#6b7280' }}>{new Date(a.created_at).toLocaleDateString()}</td>
                                        <td style={{ padding: '12px 16px' }}>{statusBadge(a.status)}</td>
                                    </tr>
                                ))
                            )}
                        </tbody>
                    </table>
                </div>
            </div>
        </AdminLayout>
    );
}
