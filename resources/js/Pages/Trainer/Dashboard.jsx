import LmsLayout from '@/Layouts/LmsLayout';
import { Head, Link } from '@inertiajs/react';

const StatCard = ({ icon, label, value, color }) => (
    <div style={{ background: '#fff', padding: '24px', borderRadius: '12px', display: 'flex', alignItems: 'center', gap: '20px', border: '1px solid #f1f5f9' }}>
        <div style={{ width: '52px', height: '52px', borderRadius: '50%', background: color, display: 'flex', alignItems: 'center', justifyContent: 'center', flexShrink: 0 }}>
            <i className={`bi ${icon}`} style={{ color: '#fff', fontSize: '20px' }}></i>
        </div>
        <div>
            <div style={{ color: '#1e293b', fontSize: '24px', fontWeight: 800 }}>{value}</div>
            <div style={{ color: '#64748b', fontSize: '13px', fontWeight: 500 }}>{label}</div>
        </div>
    </div>
);

export default function TrainerDashboard({ auth, stats }) {
    return (
        <LmsLayout title="Trainer Dashboard">
            <Head title="Trainer Dashboard" />

            <div className="row g-4 mb-4">
                <div className="col-12 col-md-3"><StatCard icon="bi-journal-bookmark" label="Active Courses" value={stats?.courses || 0} color="#e3000f" /></div>
                <div className="col-12 col-md-3"><StatCard icon="bi-people" label="Total Students" value={stats?.students || 0} color="#1e3a8a" /></div>
                <div className="col-12 col-md-3"><StatCard icon="bi-star-fill" label="Avg Rating" value="4.8" color="#f59e0b" /></div>
                <div className="col-12 col-md-3"><StatCard icon="bi-camera-video" label="Live Classes" value={stats?.live_classes || 0} color="#10b981" /></div>
            </div>

            <div className="row g-4">
                <div className="col-12 col-lg-8">
                    <div style={{ background: '#fff', borderRadius: '12px', border: '1px solid #f1f5f9', overflow: 'hidden' }}>
                        <div style={{ padding: '24px', borderBottom: '1px solid #f1f5f9' }}>
                            <h2 style={{ fontSize: '18px', fontWeight: 800, color: '#1e293b', margin: 0 }}>My Recent Courses</h2>
                        </div>
                        <div style={{ padding: '48px 0', textAlign: 'center' }}>
                            <div style={{ color: '#64748b', fontSize: '14px' }}>No courses assigned yet.</div>
                        </div>
                    </div>
                </div>

                <div className="col-12 col-lg-4">
                    <div style={{ background: '#fff', borderRadius: '12px', border: '1px solid #f1f5f9', overflow: 'hidden' }}>
                        <div style={{ padding: '24px', borderBottom: '1px solid #f1f5f9' }}>
                            <h2 style={{ fontSize: '18px', fontWeight: 800, color: '#1e293b', margin: 0 }}>Quick Actions</h2>
                        </div>
                        <div style={{ padding: '24px', display: 'flex', flexDirection: 'column', gap: '12px' }}>
                            <button className="btn w-100" style={{ background: '#e3000f', color: '#fff', fontWeight: 600 }}>Create Live Class</button>
                            <button className="btn w-100" style={{ border: '1px solid #1e3a8a', color: '#1e3a8a', fontWeight: 600 }}>Upload Material</button>
                        </div>
                    </div>
                </div>
            </div>
        </LmsLayout>
    );
}
