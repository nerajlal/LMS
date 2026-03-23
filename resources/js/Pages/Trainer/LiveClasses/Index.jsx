import LmsLayout from '@/Layouts/LmsLayout';
import { Head, Link } from '@inertiajs/react';

export default function TrainerLiveClassesIndex({ classes }) {
    return (
        <LmsLayout title="My Live Classes">
            <Head title="My Live Classes - Trainer" />
            
            <div className="d-flex justify-content-between align-items-center mb-4">
                <h1 style={{ fontSize: '24px', fontWeight: 800, color: '#1e293b', margin: 0 }}>My Live Classes</h1>
                <Link href={route('trainer.live-classes.create')} className="btn" style={{ background: '#e3000f', color: '#fff', fontWeight: 600, padding: '10px 20px', borderRadius: '8px' }}>
                    <i className="bi bi-plus-lg me-2"></i> Schedule Class
                </Link>
            </div>

            <div style={{ background: '#fff', borderRadius: '12px', border: '1px solid #f1f5f9', overflow: 'hidden' }}>
                {classes.length === 0 ? (
                    <div style={{ padding: '64px 24px', textAlign: 'center' }}>
                        <div style={{ width: '64px', height: '64px', borderRadius: '50%', background: '#fef2f2', color: '#e3000f', display: 'flex', alignItems: 'center', justifyContent: 'center', margin: '0 auto 16px' }}>
                            <i className="bi bi-camera-video" style={{ fontSize: '28px' }}></i>
                        </div>
                        <h3 style={{ fontSize: '18px', fontWeight: 700, color: '#1e293b', marginBottom: '8px' }}>No Live Classes Scheduled</h3>
                        <p style={{ color: '#64748b', fontSize: '14px', maxWidth: '400px', margin: '0 auto 24px' }}>
                            You haven't scheduled any live classes yet. Click the button above to schedule your first class for your students.
                        </p>
                    </div>
                ) : (
                    <table className="table mb-0" style={{ fontSize: '14px' }}>
                        <thead style={{ background: '#f8fafc' }}>
                            <tr>
                                <th style={{ padding: '16px 24px', color: '#64748b', fontWeight: 600, borderBottom: '1px solid #f1f5f9' }}>Class Details</th>
                                <th style={{ padding: '16px 24px', color: '#64748b', fontWeight: 600, borderBottom: '1px solid #f1f5f9' }}>Course</th>
                                <th style={{ padding: '16px 24px', color: '#64748b', fontWeight: 600, borderBottom: '1px solid #f1f5f9' }}>Schedule</th>
                                <th style={{ padding: '16px 24px', color: '#64748b', fontWeight: 600, borderBottom: '1px solid #f1f5f9' }}>Status</th>
                                <th style={{ padding: '16px 24px', color: '#64748b', fontWeight: 600, borderBottom: '1px solid #f1f5f9', textAlign: 'right' }}>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {classes.map(cls => (
                                <tr key={cls.id}>
                                    <td style={{ padding: '16px 24px', verticalAlign: 'middle', borderBottom: '1px solid #f1f5f9' }}>
                                        <div style={{ fontWeight: 700, color: '#1e293b' }}>{cls.title}</div>
                                        <div style={{ color: '#64748b', fontSize: '12px', marginTop: '4px' }}>Host: {cls.instructor_name}</div>
                                    </td>
                                    <td style={{ padding: '16px 24px', verticalAlign: 'middle', borderBottom: '1px solid #f1f5f9' }}>
                                        <span style={{ color: '#475569', fontWeight: 500 }}>{cls.course?.title || 'General'}</span>
                                    </td>
                                    <td style={{ padding: '16px 24px', verticalAlign: 'middle', borderBottom: '1px solid #f1f5f9' }}>
                                        <div style={{ color: '#1e293b', fontWeight: 600 }}>{new Date(cls.start_time).toLocaleDateString()}</div>
                                        <div style={{ color: '#64748b', fontSize: '12px' }}>{new Date(cls.start_time).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})} ({cls.duration})</div>
                                    </td>
                                    <td style={{ padding: '16px 24px', verticalAlign: 'middle', borderBottom: '1px solid #f1f5f9' }}>
                                        {cls.status === 'live' ? (
                                            <span style={{ background: '#fef2f2', color: '#e3000f', padding: '4px 10px', borderRadius: '20px', fontSize: '12px', fontWeight: 700, display: 'inline-flex', alignItems: 'center', gap: '4px' }}>
                                                <span style={{ width: '6px', height: '6px', borderRadius: '50%', background: '#e3000f', animation: 'pulse 2s infinite' }}></span>
                                                LIVE NOW
                                            </span>
                                        ) : (
                                            <span style={{ background: '#f1f5f9', color: '#64748b', padding: '4px 10px', borderRadius: '20px', fontSize: '12px', fontWeight: 600 }}>
                                                {cls.status.charAt(0).toUpperCase() + cls.status.slice(1)}
                                            </span>
                                        )}
                                    </td>
                                    <td style={{ padding: '16px 24px', verticalAlign: 'middle', borderBottom: '1px solid #f1f5f9', textAlign: 'right' }}>
                                        <a href={cls.zoom_link} target="_blank" rel="noreferrer" className="btn btn-sm" style={{ background: '#eff6ff', color: '#2563eb', fontWeight: 600 }}>
                                            Join as Host
                                        </a>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                )}
            </div>
            <style>{`
                @keyframes pulse { 0% { opacity: 1; } 50% { opacity: 0.4; transform: scale(1.2); } 100% { opacity: 1; } }
            `}</style>
        </LmsLayout>
    );
}
