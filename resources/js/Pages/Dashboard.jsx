import LmsLayout from '@/Layouts/LmsLayout';
import { Head, Link } from '@inertiajs/react';

const StatCard = ({ icon, label, value, color, sub }) => (
    <div style={{
        background: 'rgba(255,255,255,0.04)',
        border: '1px solid rgba(255,255,255,0.08)',
        borderRadius: '16px',
        padding: '24px',
        display: 'flex',
        flexDirection: 'column',
        gap: '8px',
    }}>
        <div style={{
            width: '44px', height: '44px', borderRadius: '12px',
            background: `${color}22`,
            display: 'flex', alignItems: 'center', justifyContent: 'center',
        }}>
            <i className={`bi ${icon}`} style={{ color, fontSize: '20px' }}></i>
        </div>
        <div style={{ color: 'rgba(255,255,255,0.5)', fontSize: '13px', marginTop: '4px' }}>{label}</div>
        <div style={{ color: '#fff', fontSize: '28px', fontWeight: 700 }}>{value}</div>
        {sub && <div style={{ color: 'rgba(255,255,255,0.4)', fontSize: '12px' }}>{sub}</div>}
    </div>
);

const CourseProgressCard = ({ title, progress, thumbnail, instructor }) => (
    <div style={{
        background: 'rgba(255,255,255,0.04)',
        border: '1px solid rgba(255,255,255,0.08)',
        borderRadius: '14px',
        overflow: 'hidden',
        transition: 'transform 0.2s, box-shadow 0.2s',
    }}
        onMouseEnter={e => { e.currentTarget.style.transform = 'translateY(-4px)'; e.currentTarget.style.boxShadow = '0 12px 40px rgba(124,58,237,0.15)'; }}
        onMouseLeave={e => { e.currentTarget.style.transform = 'translateY(0)'; e.currentTarget.style.boxShadow = 'none'; }}
    >
        <div style={{ height: '140px', background: 'linear-gradient(135deg, #7c3aed22, #4f46e522)', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
            <i className="bi bi-play-circle" style={{ color: '#7c3aed', fontSize: '48px' }}></i>
        </div>
        <div className="p-3">
            <div style={{ color: '#fff', fontWeight: 600, fontSize: '14px', marginBottom: '4px' }}>{title}</div>
            <div style={{ color: 'rgba(255,255,255,0.45)', fontSize: '12px', marginBottom: '12px' }}>{instructor}</div>
            <div style={{ background: 'rgba(255,255,255,0.08)', borderRadius: '100px', height: '6px', marginBottom: '6px' }}>
                <div style={{ width: `${progress}%`, height: '100%', background: 'linear-gradient(90deg, #7c3aed, #4f46e5)', borderRadius: '100px', transition: 'width 0.5s' }}></div>
            </div>
            <div style={{ color: 'rgba(255,255,255,0.4)', fontSize: '11px' }}>{progress}% complete</div>
        </div>
    </div>
);

export default function Dashboard({ auth, stats, enrolledCourses, upcomingClasses }) {
    const courses = enrolledCourses || [
        { id: 1, title: 'Full Stack Web Development', progress: 65, instructor: 'Prof. Rao', thumbnail: null },
        { id: 2, title: 'Data Science & ML', progress: 30, instructor: 'Prof. Sharma', thumbnail: null },
        { id: 3, title: 'UI/UX Design Principles', progress: 82, instructor: 'Prof. Nair', thumbnail: null },
    ];

    const liveClasses = upcomingClasses || [
        { id: 1, title: 'React Advanced Patterns', time: 'Today, 3:00 PM', host: 'Prof. Rao' },
        { id: 2, title: 'Machine Learning Lab', time: 'Tomorrow, 11:00 AM', host: 'Prof. Sharma' },
    ];

    return (
        <LmsLayout>
            <Head title="Dashboard" />

            {/* Welcome Banner */}
            <div style={{
                background: 'linear-gradient(135deg, #7c3aed, #4f46e5)',
                borderRadius: '20px',
                padding: '32px',
                marginBottom: '28px',
                position: 'relative',
                overflow: 'hidden',
            }}>
                <div style={{ position: 'absolute', top: '-40px', right: '-40px', width: '200px', height: '200px', background: 'rgba(255,255,255,0.06)', borderRadius: '50%' }}></div>
                <div style={{ position: 'absolute', bottom: '-60px', right: '80px', width: '150px', height: '150px', background: 'rgba(255,255,255,0.04)', borderRadius: '50%' }}></div>
                <div style={{ position: 'relative' }}>
                    <div style={{ color: 'rgba(255,255,255,0.8)', fontSize: '14px', marginBottom: '4px' }}>Welcome back 👋</div>
                    <h1 style={{ color: '#fff', fontSize: '26px', fontWeight: 700, margin: '0 0 8px 0' }}>{auth?.user?.name || 'Student'}</h1>
                    <div style={{ color: 'rgba(255,255,255,0.7)', fontSize: '14px' }}>You have <strong style={{ color: '#fff' }}>3 active courses</strong> and <strong style={{ color: '#fff' }}>1 upcoming class</strong> today.</div>
                </div>
            </div>

            {/* Stats */}
            <div className="row g-3 mb-4">
                <div className="col-6 col-md-3">
                    <StatCard icon="bi-collection-play" label="Enrolled Courses" value={stats?.enrolled || 3} color="#7c3aed" />
                </div>
                <div className="col-6 col-md-3">
                    <StatCard icon="bi-check-circle" label="Completed" value={stats?.completed || 1} color="#10b981" />
                </div>
                <div className="col-6 col-md-3">
                    <StatCard icon="bi-camera-video" label="Live Classes" value={stats?.liveClasses || 2} color="#f59e0b" sub="This week" />
                </div>
                <div className="col-6 col-md-3">
                    <StatCard icon="bi-cash-stack" label="Fees Due" value={`₹${stats?.feesDue || '5,000'}`} color="#ef4444" />
                </div>
            </div>

            <div className="row g-4">
                {/* My Courses */}
                <div className="col-12 col-lg-8">
                    <div className="d-flex align-items-center justify-content-between mb-3">
                        <h2 style={{ color: '#fff', fontSize: '18px', fontWeight: 700, margin: 0 }}>My Courses</h2>
                        <Link href={route('courses.index')} style={{ color: '#7c3aed', fontSize: '13px', textDecoration: 'none' }}>View All →</Link>
                    </div>
                    <div className="row g-3">
                        {courses.map(c => (
                            <div key={c.id} className="col-12 col-sm-6 col-md-4">
                                <CourseProgressCard {...c} />
                            </div>
                        ))}
                    </div>
                </div>

                {/* Upcoming Live Classes */}
                <div className="col-12 col-lg-4">
                    <div className="d-flex align-items-center justify-content-between mb-3">
                        <h2 style={{ color: '#fff', fontSize: '18px', fontWeight: 700, margin: 0 }}>Upcoming Classes</h2>
                        <Link href={route('live-classes.index')} style={{ color: '#7c3aed', fontSize: '13px', textDecoration: 'none' }}>View All →</Link>
                    </div>
                    <div className="d-flex flex-column gap-3">
                        {liveClasses.map(cls => (
                            <div key={cls.id} style={{
                                background: 'rgba(255,255,255,0.04)',
                                border: '1px solid rgba(255,255,255,0.08)',
                                borderRadius: '14px',
                                padding: '16px',
                            }}>
                                <div style={{ display: 'flex', alignItems: 'center', gap: '12px', marginBottom: '10px' }}>
                                    <div style={{ width: '40px', height: '40px', borderRadius: '10px', background: '#f59e0b22', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
                                        <i className="bi bi-camera-video-fill" style={{ color: '#f59e0b' }}></i>
                                    </div>
                                    <div>
                                        <div style={{ color: '#fff', fontSize: '14px', fontWeight: 600 }}>{cls.title}</div>
                                        <div style={{ color: 'rgba(255,255,255,0.45)', fontSize: '12px' }}>{cls.host}</div>
                                    </div>
                                </div>
                                <div style={{ color: 'rgba(255,255,255,0.5)', fontSize: '12px', marginBottom: '12px' }}>
                                    <i className="bi bi-clock me-1"></i> {cls.time}
                                </div>
                                <Link
                                    href={route('live-classes.index')}
                                    style={{
                                        display: 'block', textAlign: 'center', padding: '8px',
                                        background: 'linear-gradient(90deg, #7c3aed, #4f46e5)',
                                        color: '#fff', borderRadius: '8px', textDecoration: 'none',
                                        fontSize: '13px', fontWeight: 600,
                                    }}
                                >
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
