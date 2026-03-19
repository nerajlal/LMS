import LmsLayout from '@/Layouts/LmsLayout';
import { Head, Link } from '@inertiajs/react';

const card = {
    background: '#fff',
    borderRadius: '12px',
    boxShadow: '0 1px 3px rgba(0,0,0,0.08), 0 1px 2px rgba(0,0,0,0.05)',
    padding: '24px',
};

const StatCard = ({ icon, label, value, color, sub }) => (
    <div style={{ ...card, borderTop: `4px solid ${color}`, position: 'relative' }}>
        <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', marginBottom: '16px' }}>
            <div style={{ width: '42px', height: '42px', borderRadius: '50%', background: `${color}15`, display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
                <i className={`bi ${icon}`} style={{ color, fontSize: '18px' }}></i>
            </div>
            {sub && <span style={{ color: '#9ca3af', fontSize: '11px', fontWeight: 500, background: '#f9fafb', padding: '2px 8px', borderRadius: '10px' }}>{sub}</span>}
        </div>
        <div style={{ color: '#1f2937', fontSize: '28px', fontWeight: 800, marginBottom: '2px' }}>{value}</div>
        <div style={{ color: '#6b7280', fontSize: '13px', fontWeight: 500 }}>{label}</div>
    </div>
);

const CourseProgressCard = ({ title, progress, instructor, lessons_count }) => (
    <div style={{ 
        ...card, padding: '16px', transition: 'all 0.2s', cursor: 'pointer', border: '1px solid transparent'
    }}
    onMouseEnter={e => { e.currentTarget.style.boxShadow = '0 10px 15px -3px rgba(0,0,0,0.1)'; e.currentTarget.style.borderColor = '#e5e7eb'; }}
    onMouseLeave={e => { e.currentTarget.style.boxShadow = card.boxShadow; e.currentTarget.style.borderColor = 'transparent'; }}
    >
        <div style={{ height: '140px', background: 'linear-gradient(135deg, #eff6ff, #dbeafe)', borderRadius: '10px', display: 'flex', alignItems: 'center', justifyContent: 'center', marginBottom: '16px', position: 'relative', overflow: 'hidden' }}>
            <i className="bi bi-play-circle-fill" style={{ color: '#3b82f6', fontSize: '48px', zIndex: 1 }}></i>
            <div style={{ position: 'absolute', top: '10px', right: '10px', background: 'rgba(255,255,255,0.9)', padding: '2px 8px', borderRadius: '4px', fontSize: '10px', fontWeight: 700, color: '#111827' }}>
                {lessons_count || 0} Lessons
            </div>
        </div>
        <div style={{ color: '#111827', fontWeight: 700, fontSize: '15px', marginBottom: '4px', whiteSpace: 'nowrap', overflow: 'hidden', textOverflow: 'ellipsis' }}>{title}</div>
        <div style={{ color: '#6b7280', fontSize: '12px', marginBottom: '12px' }}>Instructor: {instructor}</div>
        <div>
            <div style={{ display: 'flex', justifyContent: 'space-between', marginBottom: '6px' }}>
                <span style={{ color: '#6b7280', fontSize: '11px', fontWeight: 600 }}>Training Progress</span>
                <span style={{ color: '#2563eb', fontSize: '11px', fontWeight: 700 }}>{progress}%</span>
            </div>
            <div style={{ height: '6px', background: '#f3f4f6', borderRadius: '100px', overflow: 'hidden' }}>
                <div style={{ width: `${progress}%`, height: '100%', background: 'linear-gradient(to right, #3b82f6, #2563eb)', borderRadius: '100px' }}></div>
            </div>
        </div>
    </div>
);

export default function Dashboard({ auth, stats, enrolledCourses, upcomingClasses }) {
    return (
        <LmsLayout title="Dashboard">
            <Head title="Student Dashboard" />

            {/* Welcome Banner */}
            <div style={{
                background: 'linear-gradient(135deg, #2563eb, #1d4ed8)',
                borderRadius: '16px',
                padding: '36px 40px',
                marginBottom: '32px',
                color: '#fff',
                position: 'relative',
                overflow: 'hidden',
                boxShadow: '0 4px 20px rgba(37, 99, 235, 0.25)',
            }}>
                <div style={{ position: 'absolute', right: '5%', top: '-25%', width: '220px', height: '220px', border: '30px solid rgba(255,255,255,0.05)', borderRadius: '50%' }}></div>
                <div style={{ position: 'absolute', right: '15%', bottom: '-35%', width: '180px', height: '180px', border: '25px solid rgba(255,255,255,0.03)', borderRadius: '50%' }}></div>
                
                <div style={{ position: 'relative', zIndex: 1 }}>
                    <div style={{ fontSize: '14px', fontWeight: 500, opacity: 0.9, marginBottom: '8px', letterSpacing: '0.05em', textTransform: 'uppercase' }}>Learning Dashboard</div>
                    <h2 style={{ fontSize: '28px', fontWeight: 800, margin: '0 0 10px 0' }}>Hi, {auth?.user?.name || 'Explorer'}! 👋</h2>
                    <div style={{ fontSize: '15px', opacity: 0.85, maxWidth: '500px', lineHeight: '1.6' }}>
                        Welcome back to your learning portal. You have <strong>{stats?.enrolled || 0} active courses</strong> in progress. Ready to continue?
                    </div>
                </div>
            </div>

            {/* Stats Row */}
            <div className="row g-4 mb-5">
                <div className="col-6 col-md-3"><StatCard icon="bi-collection-play" label="Enrolled Courses" value={stats?.enrolled || 0} color="#3b82f6" /></div>
                <div className="col-6 col-md-3"><StatCard icon="bi-check-circle" label="Completed" value={stats?.completed || 0} color="#10b981" /></div>
                <div className="col-6 col-md-3"><StatCard icon="bi-camera-video" label="Live Classes" value={stats?.liveClasses || 0} color="#f59e0b" sub="Upcoming" /></div>
                <div className="col-6 col-md-3"><StatCard icon="bi-cash-stack" label="Fees Due (₹)" value={stats?.feesDue || 0} color="#ef4444" /></div>
            </div>

            <div className="row g-4">
                {/* My Courses */}
                <div className="col-12 col-xl-8">
                    <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', marginBottom: '20px' }}>
                        <h2 style={{ color: '#111827', fontSize: '18px', fontWeight: 800, margin: 0 }}>Continue Learning</h2>
                        <Link href={route('courses.index')} style={{ color: '#2563eb', fontSize: '13px', textDecoration: 'none', fontWeight: 700 }}>Browse All <i className="bi bi-chevron-right ms-1"></i></Link>
                    </div>
                    <div className="row g-4">
                        {(enrolledCourses || []).length === 0 ? (
                            <div className="col-12">
                                <div style={{ ...card, textAlign: 'center', padding: '48px 24px', border: '2px dashed #e5e7eb', boxShadow: 'none' }}>
                                    <i className="bi bi-journal-bookmark" style={{ fontSize: '48px', color: '#9ca3af', display: 'block', marginBottom: '16px' }}></i>
                                    <div style={{ fontSize: '16px', fontWeight: 700, color: '#374151', marginBottom: '8px' }}>Not enrolled in any courses yet</div>
                                    <p style={{ color: '#6b7280', fontSize: '14px', marginBottom: '20px' }}>Jump start your career by enrolling in one of our premium courses.</p>
                                    <Link href={route('courses.index')} style={{ background: '#2563eb', color: '#fff', padding: '10px 24px', borderRadius: '8px', textDecoration: 'none', fontWeight: 600, fontSize: '14px' }}>Explore Courses</Link>
                                </div>
                            </div>
                        ) : (
                            enrolledCourses.map(c => (
                                <div key={c.id} className="col-12 col-md-4">
                                    <CourseProgressCard {...c} />
                                </div>
                            ))
                        )}
                    </div>
                </div>

                {/* Upcoming Classes */}
                <div className="col-12 col-xl-4">
                    <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', marginBottom: '20px' }}>
                        <h2 style={{ color: '#111827', fontSize: '18px', fontWeight: 800, margin: 0 }}>Live Classes</h2>
                        <Link href={route('live-classes.index')} style={{ color: '#2563eb', fontSize: '13px', textDecoration: 'none', fontWeight: 700 }}>Full Schedule <i className="bi bi-calendar3 ms-2"></i></Link>
                    </div>
                    <div style={{ display: 'flex', flexDirection: 'column', gap: '16px' }}>
                        {upcomingClasses.map(cls => (
                            <div key={cls.id} style={{ ...card, padding: '20px', border: '1px solid #f3f4f6' }}>
                                <div style={{ display: 'flex', gap: '16px', marginBottom: '16px' }}>
                                    <div style={{ width: '44px', height: '44px', borderRadius: '12px', background: '#fef3c7', display: 'flex', alignItems: 'center', justifyContent: 'center', flexShrink: 0 }}>
                                        <i className="bi bi-camera-video" style={{ color: '#f59e0b', fontSize: '20px' }}></i>
                                    </div>
                                    <div>
                                        <div style={{ color: '#111827', fontSize: '14px', fontWeight: 700, marginBottom: '2px' }}>{cls.title}</div>
                                        <div style={{ color: '#6b7280', fontSize: '12px', fontWeight: 500 }}>by {cls.host}</div>
                                    </div>
                                </div>
                                <div style={{ padding: '8px 12px', background: '#f9fafb', borderRadius: '8px', marginBottom: '16px', display: 'flex', alignItems: 'center', gap: '8px' }}>
                                    <i className="bi bi-clock-history" style={{ color: '#3b82f6', fontSize: '14px' }}></i>
                                    <span style={{ color: '#4b5563', fontSize: '12px', fontWeight: 600 }}>{cls.time}</span>
                                </div>
                                <Link href={route('live-classes.index')} style={{
                                    display: 'block', textAlign: 'center', padding: '10px',
                                    background: '#2563eb', color: '#fff', borderRadius: '8px',
                                    textDecoration: 'none', fontSize: '13px', fontWeight: 700,
                                    transition: 'all 0.2s'
                                }}
                                onMouseEnter={e => e.currentTarget.style.background = '#1d4ed8'}
                                onMouseLeave={e => e.currentTarget.style.background = '#2563eb'}
                                >
                                    Join Session Now
                                </Link>
                            </div>
                        ))}
                    </div>
                </div>
            </div>
        </LmsLayout>
    );
}
