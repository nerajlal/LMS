import LmsLayout from '@/Layouts/LmsLayout';
import { Head, Link } from '@inertiajs/react';
import { useState } from 'react';

const cardStyle = {
    background: '#fff',
    borderRadius: '16px',
    boxShadow: '0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03)',
    border: '1px solid #f1f5f9',
};

const TabButton = ({ active, children, onClick }) => (
    <button onClick={onClick} style={{
        padding: '12px 24px', background: 'transparent', border: 'none', cursor: 'pointer',
        color: active ? '#2563eb' : '#64748b',
        fontWeight: active ? 700 : 500,
        fontSize: '14px',
        borderBottom: active ? '3px solid #2563eb' : '3px solid transparent',
        transition: 'all 0.2s',
        marginBottom: '-1px',
    }}>
        {children}
    </button>
);

export default function CourseShow({ auth, course, isEnrolled }) {
    const [activeTab, setActiveTab] = useState('overview');
    const [activeLesson, setActiveLesson] = useState(isEnrolled ? (course.lessons?.[0] || null) : null);

    const lessons = course.lessons || [];

    return (
        <LmsLayout title={course.title}>
            <Head title={`${course.title} - Course Details`} />
            
            <div className="row g-4">
                {/* Main Content Area */}
                <div className="col-12 col-xl-8">
                    {/* Video Player Section */}
                    <div style={{ ...cardStyle, overflow: 'hidden', marginBottom: '32px', background: '#000' }}>
                        {isEnrolled && activeLesson ? (
                            <div style={{ position: 'relative', paddingTop: '56.25%' }}>
                                <iframe
                                    src={`${activeLesson.video_url}?autoplay=0&rel=0`}
                                    title={activeLesson.title}
                                    style={{ position: 'absolute', top: 0, left: 0, width: '100%', height: '100%', border: 'none' }}
                                    allowFullScreen
                                ></iframe>
                            </div>
                        ) : (
                            <div style={{ height: '400px', display: 'flex', flexDirection: 'column', alignItems: 'center', justifyContent: 'center', textAlign: 'center', background: 'linear-gradient(45deg, #1e293b, #0f172a)', color: '#fff', padding: '40px' }}>
                                <div style={{ width: '80px', height: '80px', borderRadius: '50%', background: 'rgba(255,255,255,0.1)', display: 'flex', alignItems: 'center', justifyContent: 'center', marginBottom: '24px' }}>
                                    <i className="bi bi-lock-fill" style={{ fontSize: '32px', color: '#f59e0b' }}></i>
                                </div>
                                <h3 style={{ fontSize: '22px', fontWeight: 800, marginBottom: '12px' }}>Content Locked</h3>
                                <p style={{ fontSize: '15px', color: '#94a3b8', maxWidth: '400px', marginBottom: '24px' }}>
                                    You need to be enrolled in this course to access the video lessons and study materials.
                                </p>
                                <Link href={route('admissions.create')} style={{ background: '#2563eb', color: '#fff', padding: '12px 32px', borderRadius: '10px', textDecoration: 'none', fontWeight: 700, boxShadow: '0 10px 15px -3px rgba(37,99,235,0.4)' }}>
                                    Enroll to Unlock
                                </Link>
                            </div>
                        )}
                        {isEnrolled && activeLesson && (
                            <div style={{ padding: '16px 24px', background: '#fff', borderTop: '1px solid #f1f5f9', display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
                                <div style={{ fontSize: '13px', fontWeight: 700, color: '#1e293b' }}>
                                    <span style={{ color: '#64748b', fontWeight: 500, marginRight: '8px' }}>Now Playing:</span> 
                                    {activeLesson.title}
                                </div>
                                <div style={{ fontSize: '12px', color: '#64748b', fontWeight: 600 }}>
                                    <i className="bi bi-clock me-1"></i> 14:20
                                </div>
                            </div>
                        )}
                    </div>

                    {/* Course Info Tabs */}
                    <div style={{ ...cardStyle, padding: '0', overflow: 'hidden' }}>
                        <div style={{ borderBottom: '1px solid #f1f5f9', padding: '0 24px', display: 'flex' }}>
                            <TabButton active={activeTab === 'overview'} onClick={() => setActiveTab('overview')}>Overview</TabButton>
                            <TabButton active={activeTab === 'curriculum'} onClick={() => setActiveTab('curriculum')}>Curriculum ({lessons.length})</TabButton>
                            <TabButton active={activeTab === 'instructor'} onClick={() => setActiveTab('instructor')}>Instructor</TabButton>
                        </div>

                        <div style={{ padding: '32px' }}>
                            {activeTab === 'overview' && (
                                <div>
                                    <h3 style={{ fontSize: '18px', fontWeight: 800, color: '#1e293b', marginBottom: '16px' }}>About this course</h3>
                                    <p style={{ fontSize: '15px', lineHeight: '1.8', color: '#475569', marginBottom: '24px' }}>
                                        {course.description || "No description available for this course."}
                                    </p>
                                    <h4 style={{ fontSize: '16px', fontWeight: 700, color: '#1e293b', marginBottom: '12px' }}>What you'll learn</h4>
                                    <div className="row g-3">
                                        {["Master industry-standard tools", "Build real-world projects", "Hands-on coding exercises", "Lifetime access to updates"].map((item, i) => (
                                            <div key={i} className="col-md-6">
                                                <div style={{ display: 'flex', gap: '10px', alignItems: 'start', fontSize: '14px', color: '#475569' }}>
                                                    <i className="bi bi-check-circle-fill" style={{ color: '#10b981', marginTop: '2px' }}></i>
                                                    <span>{item}</span>
                                                </div>
                                            </div>
                                        ))}
                                    </div>
                                </div>
                            )}

                            {activeTab === 'curriculum' && (
                                <div style={{ display: 'flex', flexDirection: 'column', gap: '12px' }}>
                                    {lessons.length === 0 ? (
                                        <div style={{ textAlign: 'center', padding: '40px', color: '#94a3b8' }}>No lessons found for this course.</div>
                                    ) : (
                                        lessons.map((lesson, idx) => (
                                            <div 
                                                key={lesson.id}
                                                onClick={() => isEnrolled && setActiveLesson(lesson)}
                                                style={{
                                                    display: 'flex', alignItems: 'center', gap: '16px',
                                                    padding: '16px 20px', borderRadius: '12px',
                                                    background: activeLesson?.id === lesson.id ? '#eff6ff' : '#f8fafc',
                                                    border: activeLesson?.id === lesson.id ? '1px solid #bfdbfe' : '1px solid #f1f5f9',
                                                    cursor: isEnrolled ? 'pointer' : 'default',
                                                    transition: 'all 0.2s',
                                                }}
                                            >
                                                <div style={{ 
                                                    width: '32px', height: '32px', borderRadius: '50%', 
                                                    background: activeLesson?.id === lesson.id ? '#2563eb' : '#fff',
                                                    display: 'flex', alignItems: 'center', justifyContent: 'center',
                                                    flexShrink: 0, boxShadow: '0 2px 4px rgba(0,0,0,0.05)',
                                                    border: activeLesson?.id === lesson.id ? 'none' : '1px solid #e2e8f0'
                                                }}>
                                                    {isEnrolled ? (
                                                        <i className={`bi ${activeLesson?.id === lesson.id ? 'bi-play-fill' : 'bi-play'}`} style={{ color: activeLesson?.id === lesson.id ? '#fff' : '#2563eb', fontSize: '14px' }}></i>
                                                    ) : (
                                                        <i className="bi bi-lock-fill" style={{ color: '#94a3b8', fontSize: '12px' }}></i>
                                                    )}
                                                </div>
                                                <div style={{ flex: 1 }}>
                                                    <div style={{ fontSize: '14px', fontWeight: 700, color: '#1e293b' }}>{idx + 1}. {lesson.title}</div>
                                                    <div style={{ fontSize: '12px', color: '#64748b', fontWeight: 500 }}>Video Lesson • 12:45</div>
                                                </div>
                                                {isEnrolled && activeLesson?.id === lesson.id && (
                                                    <span style={{ fontSize: '11px', fontWeight: 800, color: '#2563eb', background: '#fff', padding: '2px 8px', borderRadius: '20px', textTransform: 'uppercase' }}>Playing</span>
                                                )}
                                            </div>
                                        ))
                                    )}
                                </div>
                            )}

                            {activeTab === 'instructor' && (
                                <div style={{ display: 'flex', gap: '24px', flexWrap: 'wrap' }}>
                                    <div style={{ width: '120px', height: '120px', borderRadius: '20px', background: 'linear-gradient(135deg, #eff6ff, #dbeafe)', display: 'flex', alignItems: 'center', justifyContent: 'center', flexShrink: 0 }}>
                                        <i className="bi bi-person-fill" style={{ fontSize: '64px', color: '#3b82f6' }}></i>
                                    </div>
                                    <div>
                                        <h3 style={{ fontSize: '20px', fontWeight: 800, color: '#1e293b', marginBottom: '4px' }}>{course.instructor_name || "Expert Instructor"}</h3>
                                        <div style={{ color: '#2563eb', fontSize: '13px', fontWeight: 700, marginBottom: '12px' }}>Senior Developer & Educator</div>
                                        <p style={{ fontSize: '14px', color: '#475569', lineHeight: '1.6', maxWidth: '400px' }}>
                                            Join the most popular instructor on EduLMS. With over 10 years of experience in technical education, {course.instructor_name} makes complex topics easy to understand.
                                        </p>
                                    </div>
                                </div>
                            )}
                        </div>
                    </div>
                </div>

                {/* Sidebar Details Area */}
                <div className="col-12 col-xl-4">
                    <div style={{ ...cardStyle, padding: '32px', position: 'sticky', top: '96px' }}>
                        <div style={{ background: '#f8fafc', borderRadius: '12px', padding: '20px', marginBottom: '24px', border: '1px solid #f1f5f9' }}>
                            <div style={{ color: '#64748b', fontSize: '12px', fontWeight: 700, textTransform: 'uppercase', marginBottom: '8px', letterSpacing: '0.05em' }}>Course Price</div>
                            <div style={{ display: 'flex', alignItems: 'baseline', gap: '8px' }}>
                                <span style={{ fontSize: '32px', fontWeight: 900, color: '#1e293b' }}>₹{course.price?.toLocaleString()}</span>
                                <span style={{ fontSize: '14px', color: '#94a3b8', textDecoration: 'line-through' }}>₹{(course.price * 1.5).toLocaleString()}</span>
                            </div>
                            <div style={{ fontSize: '12px', color: '#ef4444', fontWeight: 700, marginTop: '4px' }}>
                                <i className="bi bi-lightning-charge-fill me-1"></i> Limited time offer: 30% Off
                            </div>
                        </div>

                        {!isEnrolled ? (
                            <Link href={route('admissions.create')} style={{ 
                                display: 'block', textAlign: 'center', padding: '16px', background: '#2563eb', 
                                color: '#fff', borderRadius: '12px', textDecoration: 'none', fontWeight: 800, 
                                fontSize: '16px', marginBottom: '16px', boxShadow: '0 10px 15px -3px rgba(37,99,235,0.3)',
                                transition: 'all 0.2s'
                            }}
                            onMouseEnter={e => e.currentTarget.style.transform = 'translateY(-2px)'}
                            onMouseLeave={e => e.currentTarget.style.transform = ''}
                            >
                                Enroll in Course
                            </Link>
                        ) : (
                            <div style={{ 
                                textAlign: 'center', padding: '16px', background: '#f0fdf4', 
                                color: '#15803d', borderRadius: '12px', fontWeight: 800, 
                                fontSize: '14px', marginBottom: '16px', border: '1px solid #bbf7d0'
                            }}>
                                <i className="bi bi-patch-check-fill me-2"></i> Successfully Enrolled
                            </div>
                        )}

                        <div style={{ color: '#64748b', fontSize: '12px', textAlign: 'center', marginBottom: '24px', fontWeight: 500 }}>
                            <i className="bi bi-arrow-counterclockwise"></i> 30-Day Money-Back Guarantee
                        </div>

                        <div style={{ borderTop: '1px solid #f1f5f9', paddingTop: '24px' }}>
                            <h4 style={{ fontSize: '15px', fontWeight: 800, color: '#1e293b', marginBottom: '16px' }}>Course Includes:</h4>
                            <div style={{ display: 'flex', flexDirection: 'column', gap: '14px' }}>
                                {[
                                    { icon: 'bi-collection-play', text: `${lessons.length} HD video lessons` },
                                    { icon: 'bi-file-earmark-arrow-down', text: '5 Downloadable resources' },
                                    { icon: 'bi-patch-check', text: 'Certificate of completion' },
                                    { icon: 'bi-pc-display', text: 'Access on mobile and TV' },
                                    { icon: 'bi-infinity', text: 'Full lifetime access' },
                                ].map((item, i) => (
                                    <div key={i} style={{ display: 'flex', alignItems: 'center', gap: '12px', color: '#475569', fontSize: '13px', fontWeight: 500 }}>
                                        <i className={`bi ${item.icon}`} style={{ color: '#2563eb', fontSize: '16px', width: '20px', textAlign: 'center' }}></i>
                                        {item.text}
                                    </div>
                                ))}
                            </div>
                        </div>

                        <div style={{ marginTop: '32px', background: '#f8fafc', borderRadius: '12px', padding: '16px', border: '1px solid #f1f5f9' }}>
                            <div style={{ display: 'flex', alignItems: 'center', gap: '12px' }}>
                                <div style={{ width: '40px', height: '40px', borderRadius: '50%', background: '#fff', display: 'flex', alignItems: 'center', justifyContent: 'center', border: '1px solid #e2e8f0' }}>
                                    <i className="bi bi-headphones" style={{ color: '#2563eb' }}></i>
                                </div>
                                <div>
                                    <div style={{ fontSize: '13px', fontWeight: 700, color: '#1e293b' }}>Need help?</div>
                                    <div style={{ fontSize: '11px', color: '#64748b' }}>Contact our support team</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </LmsLayout>
    );
}
