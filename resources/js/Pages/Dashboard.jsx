import LmsLayout from '@/Layouts/LmsLayout';
import { Head, Link } from '@inertiajs/react';

const card = {
    background: '#fff',
    borderRadius: '8px',
    boxShadow: '0 1px 3px rgba(0,0,0,0.08), 0 1px 2px rgba(0,0,0,0.05)',
    padding: '20px',
};

const StatCard = ({ icon, label, value, color, sub }) => (
    <div style={{ ...card, borderTop: `3px solid ${color}` }}>
        <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', marginBottom: '12px' }}>
            <div style={{ width: '40px', height: '40px', borderRadius: '8px', background: `${color}18`, display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
                <i className={`bi ${icon}`} style={{ color, fontSize: '18px' }}></i>
            </div>
            <span style={{ color: '#9ca3af', fontSize: '12px' }}>{sub || 'Total'}</span>
        </div>
        <div style={{ color: '#1f2937', fontSize: '26px', fontWeight: 700, marginBottom: '2px' }}>{value}</div>
        <div style={{ color: '#6b7280', fontSize: '13px' }}>{label}</div>
    </div>
);

const CourseProgressCard = ({ title, progress, instructor }) => (
    <div style={{ ...card, padding: '16px' }}>
        <div style={{ height: '120px', background: 'linear-gradient(135deg, #eff6ff, #dbeafe)', borderRadius: '6px', display: 'flex', alignItems: 'center', justifyContent: 'center', marginBottom: '12px' }}>
            <i className="bi bi-play-circle" style={{ color: '#3b82f6', fontSize: '40px' }}></i>
        </div>
        <div style={{ color: '#1f2937', fontWeight: 600, fontSize: '14px', marginBottom: '4px' }}>{title}</div>
        <div style={{ color: '#6b7280', fontSize: '12px', marginBottom: '10px' }}>{instructor}</div>
        <div>
            <div style={{ display: 'flex', justifyContent: 'space-between', marginBottom: '4px' }}>
                <span style={{ color: '#6b7280', fontSize: '11px' }}>Progress</span>
                <span style={{ color: '#2563eb', fontSize: '11px', fontWeight: 600 }}>{progress}%</span>
            </div>
            <div style={{ height: '5px', background: '#e5e7eb', borderRadius: '100px' }}>
                <div style={{ width: `${progress}%`, height: '100%', background: '#2563eb', borderRadius: '100px' }}></div>
            </div>
        </div>
    </div>
);

export default function Dashboard({ auth, stats, enrolledCourses, upcomingClasses }) {
    const courses = enrolledCourses || [
        { id: 1, title: 'Full Stack Web Development', progress: 65, instructor: 'Prof. Rao' },
        { id: 2, title: 'Data Science & ML', progress: 30, instructor: 'Prof. Sharma' },
        { id: 3, title: 'UI/UX Design', progress: 82, instructor: 'Prof. Nair' },
    ];

    const liveClasses = upcomingClasses || [
        { id: 1, title: 'React Advanced Patterns', time: 'Today, 3:00 PM', host: 'Prof. Rao' },
        { id: 2, title: 'Machine Learning Lab', time: 'Tomorrow, 11:00 AM', host: 'Prof. Sharma' },
    ];

    return (
        <LmsLayout title="Dashboard">
            <Head title="Dashboard" />

            {/* Welcome Banner */}
            <div style={{
                background: 'linear-gradient(to right, #3b82f6, #2563eb)',
                borderRadius: '10px',
                padding: '28px 32px',
                marginBottom: '24px',
                color: '#fff',
                position: 'relative',
                overflow: 'hidden',
            }}>
                <div style={{ position: 'absolute', right: '-20px', top: '-20px', width: '160px', height: '160px', border: '2px solid rgba(255,255,255,0.1)', borderRadius: '50%' }}></div>
                <div style={{ position: 'absolute', right: '60px', bottom: '-40px', width: '120px', height: '120px', border: '2px solid rgba(255,255,255,0.08)', borderRadius: '50%' }}></div>
                <div style={{ position: 'relative' }}>
                    <div style={{ fontSize: '13px', opacity: 0.85, marginBottom: '4px' }}>Welcome back 👋</div>
                    <h2 style={{ fontSize: '22px', fontWeight: 700, margin: '0 0 6px 0' }}>{auth?.user?.name || 'Student'}</h2>
                    <div style={{ fontSize: '13px', opacity: 0.8 }}>You have <strong>3 active courses</strong> and <strong>1 upcoming class</strong> today.</div>
                </div>
            </div>

            {/* Stats Row */}
            <div className="row g-3 mb-4">
                <div className="col-6 col-md-3"><StatCard icon="bi-collection-play" label="Enrolled Courses" value={stats?.enrolled || 3} color="#3b82f6" /></div>
                <div className="col-6 col-md-3"><StatCard icon="bi-check-circle" label="Completed" value={stats?.completed || 1} color="#10b981" /></div>
                <div className="col-6 col-md-3"><StatCard icon="bi-camera-video" label="Live Classes" value={stats?.liveClasses || 2} color="#f59e0b" sub="This week" /></div>
                <div className="col-6 col-md-3"><StatCard icon="bi-cash-stack" label="Fees Due" value={`₹${stats?.feesDue || '5,000'}`} color="#ec4899" /></div>
            </div>

            <div className="row g-4">
                {/* My Courses */}
                <div className="col-12 col-lg-8">
                    <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', marginBottom: '16px' }}>
                        <h2 style={{ color: '#1f2937', fontSize: '16px', fontWeight: 700, margin: 0 }}>My Courses</h2>
                        <Link href={route('courses.index')} style={{ color: '#2563eb', fontSize: '13px', textDecoration: 'none', fontWeight: 500 }}>View All →</Link>
                    </div>
                    <div className="row g-3">
                        {courses.map(c => (
                            <div key={c.id} className="col-12 col-sm-4">
                                <CourseProgressCard {...c} />
                            </div>
                        ))}
                    </div>
                </div>

                {/* Upcoming Classes */}
                <div className="col-12 col-lg-4">
                    <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', marginBottom: '16px' }}>
                        <h2 style={{ color: '#1f2937', fontSize: '16px', fontWeight: 700, margin: 0 }}>Upcoming Classes</h2>
                        <Link href={route('live-classes.index')} style={{ color: '#2563eb', fontSize: '13px', textDecoration: 'none', fontWeight: 500 }}>View All →</Link>
                    </div>
                    <div style={{ display: 'flex', flexDirection: 'column', gap: '12px' }}>
                        {liveClasses.map(cls => (
                            <div key={cls.id} style={{ ...card, padding: '16px' }}>
                                <div style={{ display: 'flex', gap: '12px', marginBottom: '10px' }}>
                                    <div style={{ width: '38px', height: '38px', borderRadius: '8px', background: '#fef3c7', display: 'flex', alignItems: 'center', justifyContent: 'center', flexShrink: 0 }}>
                                        <i className="bi bi-camera-video-fill" style={{ color: '#f59e0b', fontSize: '16px' }}></i>
                                    </div>
                                    <div>
                                        <div style={{ color: '#1f2937', fontSize: '13px', fontWeight: 600 }}>{cls.title}</div>
                                        <div style={{ color: '#9ca3af', fontSize: '12px' }}>{cls.host}</div>
                                    </div>
                                </div>
                                <div style={{ color: '#6b7280', fontSize: '12px', marginBottom: '10px' }}>
                                    <i className="bi bi-clock me-1"></i> {cls.time}
                                </div>
                                <Link href={route('live-classes.index')} style={{
                                    display: 'block', textAlign: 'center', padding: '8px',
                                    background: '#2563eb', color: '#fff', borderRadius: '6px',
                                    textDecoration: 'none', fontSize: '13px', fontWeight: 600,
                                }}>
                                    Join Class
                                </Link>
                            </div>
                        ))}
                    </div>
                </div>
            </div>
        </LmsLayout>
    );
}
