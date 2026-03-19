import LmsLayout from '@/Layouts/LmsLayout';
import { Head } from '@inertiajs/react';

const StatusBadge = ({ status }) => {
    const map = {
        pending: { color: '#f59e0b', bg: '#f59e0b22', label: 'Pending' },
        approved: { color: '#10b981', bg: '#10b98122', label: 'Approved' },
        rejected: { color: '#ef4444', bg: '#ef444422', label: 'Rejected' },
    };
    const s = map[status] || map.pending;
    return (
        <span style={{ padding: '4px 10px', borderRadius: '100px', background: s.bg, color: s.color, fontSize: '12px', fontWeight: 600 }}>
            {s.label}
        </span>
    );
};

export default function AdmissionsIndex({ auth, admissions }) {
    const list = admissions || [
        { id: 1, course: 'Full Stack Web Development', batch: 'Batch A - Morning', submitted_at: '2026-03-10', status: 'approved' },
        { id: 2, course: 'Data Science & ML', batch: 'Batch A - Morning', submitted_at: '2026-03-15', status: 'pending' },
    ];

    return (
        <LmsLayout>
            <Head title="My Admissions" />
            <div className="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h1 style={{ color: '#fff', fontSize: '24px', fontWeight: 700, margin: 0 }}>My Admissions</h1>
                    <p style={{ color: 'rgba(255,255,255,0.5)', fontSize: '14px', margin: '4px 0 0 0' }}>Track your application status</p>
                </div>
            </div>

            <div style={{ background: 'rgba(255,255,255,0.04)', border: '1px solid rgba(255,255,255,0.08)', borderRadius: '16px', overflow: 'hidden' }}>
                <table style={{ width: '100%', borderCollapse: 'collapse' }}>
                    <thead>
                        <tr style={{ background: 'rgba(255,255,255,0.04)' }}>
                            {['#', 'Course', 'Batch', 'Applied On', 'Status'].map(h => (
                                <th key={h} style={{ padding: '14px 20px', textAlign: 'left', color: 'rgba(255,255,255,0.5)', fontSize: '12px', fontWeight: 600, textTransform: 'uppercase', letterSpacing: '0.5px', borderBottom: '1px solid rgba(255,255,255,0.06)' }}>{h}</th>
                            ))}
                        </tr>
                    </thead>
                    <tbody>
                        {list.map((item, i) => (
                            <tr key={item.id} style={{ borderBottom: '1px solid rgba(255,255,255,0.06)', transition: 'background 0.15s' }}
                                onMouseEnter={e => e.currentTarget.style.background = 'rgba(255,255,255,0.02)'}
                                onMouseLeave={e => e.currentTarget.style.background = 'transparent'}
                            >
                                <td style={{ padding: '16px 20px', color: 'rgba(255,255,255,0.4)', fontSize: '13px' }}>{i + 1}</td>
                                <td style={{ padding: '16px 20px', color: '#fff', fontSize: '14px', fontWeight: 500 }}>{item.course}</td>
                                <td style={{ padding: '16px 20px', color: 'rgba(255,255,255,0.6)', fontSize: '14px' }}>{item.batch}</td>
                                <td style={{ padding: '16px 20px', color: 'rgba(255,255,255,0.5)', fontSize: '13px' }}>{item.submitted_at}</td>
                                <td style={{ padding: '16px 20px' }}><StatusBadge status={item.status} /></td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </LmsLayout>
    );
}
