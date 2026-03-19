import LmsLayout from '@/Layouts/LmsLayout';
import { Head } from '@inertiajs/react';

const cardStyle = {
    background: '#fff',
    borderRadius: '20px',
    boxShadow: '0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05)',
    padding: '24px',
    border: '1px solid #f1f5f9',
    transition: 'all 0.3s ease',
};

export default function LiveClassesIndex({ auth, classes }) {
    const liveClasses = classes || [
        {
            id: 1,
            title: 'Mastering Advanced React Hooks & State Management',
            course: 'Full Stack Web Development',
            instructor: 'Dr. Arpit Rao',
            start_time: '2026-03-20 16:00:00',
            duration: '90 mins',
            status: 'upcoming',
            zoom_link: 'https://zoom.us/j/123456789',
        },
        {
            id: 2,
            title: 'Statistical Modeling & Hypothesis Testing',
            course: 'Data Science & ML',
            instructor: 'Prof. Sneha Sharma',
            start_time: '2026-03-21 10:30:00',
            duration: '120 mins',
            status: 'upcoming',
            zoom_link: 'https://zoom.us/j/987654321',
        }
    ];

    return (
        <LmsLayout title="Live Class Schedule">
            <Head title="Live Classes - EduLMS" />

            <div style={{ marginBottom: '40px' }}>
                <h2 style={{ fontSize: '28px', fontWeight: 900, color: '#1e293b', marginBottom: '8px' }}>Join Live Sessions</h2>
                <p style={{ fontSize: '15px', color: '#64748b' }}>Connect with your instructors and peers in real-time. Don't miss out!</p>
            </div>

            <div className="row g-4">
                {liveClasses.map((cls) => (
                    <div key={cls.id} className="col-12 col-xl-6">
                        <div style={cardStyle} onMouseEnter={e => e.currentTarget.style.transform = 'translateY(-5px)'} onMouseLeave={e => e.currentTarget.style.transform = 'translateY(0)'}>
                            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'flex-start', marginBottom: '20px' }}>
                                <div style={{ padding: '6px 14px', background: '#eff6ff', color: '#2563eb', borderRadius: '30px', fontSize: '12px', fontWeight: 800, textTransform: 'uppercase', letterSpacing: '0.05em' }}>
                                    {cls.course}
                                </div>
                                <div style={{ display: 'flex', alignItems: 'center', gap: '6px', color: '#10b981', fontSize: '13px', fontWeight: 700 }}>
                                    <span style={{ width: '8px', height: '8px', background: '#10b981', borderRadius: '50%', display: 'inline-block', animation: 'pulse 2s infinite' }}></span>
                                    {cls.status === 'upcoming' ? 'Scheduled' : 'Live Now'}
                                </div>
                            </div>

                            <h3 style={{ fontSize: '20px', fontWeight: 800, color: '#1e293b', marginBottom: '16px', lineHeight: '1.4' }}>{cls.title}</h3>

                            <div style={{ display: 'flex', flexDirection: 'column', gap: '12px', marginBottom: '24px' }}>
                                <div style={{ display: 'flex', alignItems: 'center', gap: '12px', color: '#64748b', fontSize: '14px' }}>
                                    <i className="bi bi-person-circle" style={{ color: '#2563eb' }}></i>
                                    <span>Instructor: <strong style={{ color: '#1e293b' }}>{cls.instructor}</strong></span>
                                </div>
                                <div style={{ display: 'flex', alignItems: 'center', gap: '12px', color: '#64748b', fontSize: '14px' }}>
                                    <i className="bi bi-calendar3" style={{ color: '#2563eb' }}></i>
                                    <span>{new Date(cls.start_time).toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' })}</span>
                                </div>
                                <div style={{ display: 'flex', alignItems: 'center', gap: '12px', color: '#64748b', fontSize: '14px' }}>
                                    <i className="bi bi-clock" style={{ color: '#2563eb' }}></i>
                                    <span>{new Date(cls.start_time).toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' })} ({cls.duration})</span>
                                </div>
                            </div>

                            <div style={{ padding: '16px', background: '#f8fafc', borderRadius: '14px', border: '1px solid #f1f5f9', display: 'flex', alignItems: 'center', justifyContent: 'space-between' }}>
                                <div style={{ display: 'flex', alignItems: 'center', gap: '10px' }}>
                                    <div style={{ width: '32px', height: '32px', borderRadius: '8px', background: '#2D8CFF', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
                                        <i className="bi bi-camera-video-fill" style={{ color: '#fff', fontSize: '16px' }}></i>
                                    </div>
                                    <span style={{ fontSize: '13px', fontWeight: 700, color: '#1e293b' }}>Zoom Meeting</span>
                                </div>
                                <a 
                                    href={cls.zoom_link} 
                                    target="_blank" 
                                    rel="noopener noreferrer"
                                    style={{ 
                                        padding: '10px 24px', background: '#1e293b', color: '#fff', 
                                        borderRadius: '10px', textDecoration: 'none', fontSize: '13px', fontWeight: 700,
                                        transition: 'all 0.2s'
                                    }}
                                    onMouseEnter={e => e.currentTarget.style.background = '#2563eb'}
                                    onMouseLeave={e => e.currentTarget.style.background = '#1e293b'}
                                >
                                    Join Session
                                </a>
                            </div>
                        </div>
                    </div>
                ))}

                {liveClasses.length === 0 && (
                    <div className="col-12">
                        <div style={{ ...cardStyle, textAlign: 'center', padding: '64px', background: 'transparent', borderStyle: 'dashed' }}>
                            <i className="bi bi-calendar-x mb-3" style={{ fontSize: '48px', opacity: 0.2, display: 'block' }}></i>
                            <h3 style={{ fontSize: '18px', fontWeight: 800, color: '#1e293b' }}>No live classes scheduled</h3>
                            <p style={{ color: '#64748b', fontSize: '14px' }}>Check back later or follow your course announcements.</p>
                        </div>
                    </div>
                )}
            </div>

            <style>{`
                @keyframes pulse {
                    0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
                    70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(16, 185, 129, 0); }
                    100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
                }
            `}</style>
        </LmsLayout>
    );
}
