import LmsLayout from '@/Layouts/LmsLayout';
import { Head, Link } from '@inertiajs/react';

const StatusBadge = ({ status }) => {
    const map = {
        pending: { color: '#f59e0b', bg: '#fef3c7', label: 'Pending Review' },
        approved: { color: '#10b981', bg: '#d1fae5', label: 'Approved' },
        rejected: { color: '#ef4444', bg: '#fee2e2', label: 'Rejected' },
    };
    const s = map[status] || map.pending;
    return (
        <span className="badge" style={{ 
            padding: '8px 12px', 
            borderRadius: '8px', 
            background: s.bg, 
            color: s.color, 
            fontSize: '12px', 
            fontWeight: 600,
            textTransform: 'uppercase',
            letterSpacing: '0.5px'
        }}>
            {s.label}
        </span>
    );
};

export default function AdmissionsIndex({ auth, admissions }) {
    const list = admissions || [];

    return (
        <LmsLayout>
            <Head title="My Admissions" />
            
            <div className="container-fluid py-4">
                <div className="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h1 className="fw-bold text-slate-800 mb-1" style={{ fontSize: '28px' }}>My Admissions</h1>
                        <p className="text-muted mb-0">Track your course application status and history</p>
                    </div>
                </div>

                <div className="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div className="card-body p-0">
                        {list.length > 0 ? (
                            <div className="table-responsive">
                                <table className="table table-hover align-middle mb-0">
                                    <thead className="bg-light">
                                        <tr>
                                            <th className="ps-4 py-3 text-uppercase text-muted fw-bold" style={{ fontSize: '11px' }}>Course Name</th>
                                            <th className="py-3 text-uppercase text-muted fw-bold" style={{ fontSize: '11px' }}>Batch</th>
                                            <th className="py-3 text-uppercase text-muted fw-bold" style={{ fontSize: '11px' }}>Applied Date</th>
                                            <th className="py-3 text-uppercase text-muted fw-bold" style={{ fontSize: '11px' }}>Status</th>
                                            <th className="pe-4 py-3 text-end text-uppercase text-muted fw-bold" style={{ fontSize: '11px' }}>Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {list.map((item) => (
                                            <tr key={item.id} style={{ transition: 'all 0.2s' }}>
                                                <td className="ps-4 py-3">
                                                    <div className="fw-bold text-slate-700">{item.course}</div>
                                                    <div className="text-muted small">Application ID: #ADM-{item.id.toString().padStart(5, '0')}</div>
                                                </td>
                                                <td className="py-3 text-slate-600 fw-medium">
                                                    {item.batch || <span className="text-muted italic small">Not Assigned</span>}
                                                </td>
                                                <td className="py-3 text-slate-500">
                                                    {item.submitted_at}
                                                </td>
                                                <td className="py-3">
                                                    <StatusBadge status={item.status} />
                                                </td>
                                                <td className="pe-4 py-3 text-end">
                                                    <button className="btn btn-sm btn-outline-primary rounded-3 px-3">
                                                        View PDF
                                                    </button>
                                                </td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </div>
                        ) : (
                            <div className="text-center py-5">
                                <div className="mb-3">
                                    <i className="bi bi-journal-text text-muted display-4"></i>
                                </div>
                                <h4 className="fw-bold text-slate-700">No Admissions Found</h4>
                                <p className="text-muted mb-4">You haven't applied for any courses yet.</p>
                                <Link 
                                    href={route('courses.index')} 
                                    className="btn btn-primary rounded-pill px-4"
                                >
                                    Browse Courses
                                </Link>
                            </div>
                        )}
                    </div>
                </div>
            </div>
        </LmsLayout>
    );
}
