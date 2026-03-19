import LmsLayout from '@/Layouts/LmsLayout';
import { Head, Link } from '@inertiajs/react';

const card = {
    background: '#fff',
    borderRadius: '12px',
    boxShadow: '0 1px 3px rgba(0,0,0,0.08), 0 1px 2px rgba(0,0,0,0.05)',
    padding: '24px',
};

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

const CourseProgressRow = ({ title, progress, instructor, thumbnail }) => (
    <div style={{ display: 'flex', alignItems: 'center', gap: '20px', padding: '16px 0', borderBottom: '1px solid #f1f5f9' }}>
        <div style={{ width: '80px', height: '56px', borderRadius: '8px', overflow: 'hidden', flexShrink: 0, background: '#f1f5f9' }}>
            <img src={thumbnail || 'https://via.placeholder.com/80x56'} alt="" style={{ width: '100%', height: '100%', objectFit: 'cover' }} />
        </div>
        <div style={{ flex: 1, overflow: 'hidden' }}>
            <div style={{ color: '#1e293b', fontWeight: 700, fontSize: '15px', marginBottom: '6px', whiteSpace: 'nowrap', overflow: 'hidden', textOverflow: 'ellipsis' }}>{title}</div>
            <div style={{ display: 'flex', alignItems: 'center', gap: '12px' }}>
                <div style={{ fontSize: '12px', color: '#64748b', whiteSpace: 'nowrap' }}>{Math.round(progress/10)}/10 Complete</div>
                <div style={{ flex: 1, height: '4px', background: '#f1f5f9', borderRadius: '10px', overflow: 'hidden' }}>
                    <div style={{ width: `${progress}%`, height: '100%', background: '#2563eb' }}></div>
                </div>
            </div>
        </div>
        <Link href={route('courses.index')} style={{ background: '#f1f5f9', color: '#1e293b', padding: '8px 16px', borderRadius: '6px', fontSize: '13px', fontWeight: 700, textDecoration: 'none' }}>
            Resume
        </Link>
    </div>
);

const InstructorRow = ({ name, courses, avatar }) => (
    <div style={{ display: 'flex', alignItems: 'center', gap: '12px', padding: '12px 0' }}>
        <img src={avatar} alt="" style={{ width: '40px', height: '40px', borderRadius: '50%' }} />
        <div style={{ flex: 1 }}>
            <div style={{ color: '#1e293b', fontWeight: 700, fontSize: '14px' }}>{name}</div>
            <div style={{ color: '#64748b', fontSize: '12px' }}>{courses} Courses</div>
        </div>
        <button style={{ background: '#fff', border: '1px solid #e2e8f0', padding: '4px 12px', borderRadius: '6px', fontSize: '12px', fontWeight: 700, color: '#1e293b', cursor: 'pointer' }}>
            Follow
        </button>
    </div>
);

export default function Dashboard({ auth, stats, enrolledCourses, upcomingClasses }) {
    return (
        <LmsLayout title="Dashboard">
            <Head title="Student Dashboard" />

            {/* Stats Row */}
            <div className="row g-4 mb-4">
                <div className="col-12 col-md-3"><StatCard icon="bi-briefcase" label="Completed" value={stats?.completed || 0} color="#3b82f6" /></div>
                <div className="col-12 col-md-3"><StatCard icon="bi-heart" label="Wishlist" value="43" color="#f87171" /></div>
                <div className="col-12 col-md-3"><StatCard icon="bi-award" label="Certification" value="15" color="#f59e0b" /></div>
                <div className="col-12 col-md-3"><StatCard icon="bi-cart" label="Purchased" value={stats?.enrolled || 0} color="#10b981" /></div>
            </div>

            <div className="row g-4">
                {/* Main Content: Courses in progress */}
                <div className="col-12 col-lg-8">
                    <div style={{ background: '#fff', borderRadius: '12px', border: '1px solid #f1f5f9', overflow: 'hidden' }}>
                        <div style={{ padding: '24px', borderBottom: '1px solid #f1f5f9', display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
                            <h2 style={{ fontSize: '18px', fontWeight: 800, color: '#1e293b', margin: 0 }}>Courses in progress</h2>
                            <Link href={route('courses.index')} style={{ color: '#2563eb', fontSize: '13px', fontWeight: 700, textDecoration: 'none' }}>See all</Link>
                        </div>
                        <div style={{ padding: '0 24px' }}>
                            {(enrolledCourses || []).length === 0 ? (
                                <div style={{ padding: '48px 0', textAlign: 'center' }}>
                                    <div style={{ color: '#64748b', fontSize: '14px' }}>No courses in progress</div>
                                </div>
                            ) : (
                                enrolledCourses.map(c => (
                                    <CourseProgressRow key={c.id} {...c} />
                                ))
                            )}
                        </div>
                    </div>
                </div>

                {/* Sidebar: Top Instructors */}
                <div className="col-12 col-lg-4">
                    <div style={{ background: '#fff', borderRadius: '12px', border: '1px solid #f1f5f9', overflow: 'hidden' }}>
                        <div style={{ padding: '24px', borderBottom: '1px solid #f1f5f9' }}>
                            <h2 style={{ fontSize: '18px', fontWeight: 800, color: '#1e293b', margin: 0 }}>Top Instructors</h2>
                        </div>
                        <div style={{ padding: '0 24px' }}>
                            <InstructorRow name="Stella Johnson" courses="28" avatar="https://ui-avatars.com/api/?name=Stella+Johnson&background=random" />
                            <InstructorRow name="Alex Dolgove" courses="23" avatar="https://ui-avatars.com/api/?name=Alex+Dolgove&background=random" />
                            <InstructorRow name="John Michael" courses="19" avatar="https://ui-avatars.com/api/?name=John+Michael&background=random" />
                            <InstructorRow name="Dennis Han" courses="17" avatar="https://ui-avatars.com/api/?name=Dennis+Han&background=random" />
                            <InstructorRow name="Erica Jones" courses="12" avatar="https://ui-avatars.com/api/?name=Erica+Jones&background=random" />
                        </div>
                        <div style={{ padding: '16px 24px', textAlign: 'center', borderTop: '1px solid #f1f5f9' }}>
                            <Link href="#" style={{ color: '#2563eb', fontSize: '14px', fontWeight: 700, textDecoration: 'none' }}>See all</Link>
                        </div>
                    </div>

                    {/* Upcoming Live Classes (Added below) */}
                    <div style={{ marginTop: '24px', background: '#fff', borderRadius: '12px', border: '1px solid #f1f5f9', overflow: 'hidden' }}>
                        <div style={{ padding: '20px' }}>
                             <h3 style={{ fontSize: '16px', fontWeight: 800, color: '#1e293b', marginBottom: '16px' }}>Upcoming Live Classes</h3>
                             <div style={{ display: 'flex', flexDirection: 'column', gap: '12px' }}>
                                {upcomingClasses.slice(0, 2).map(cls => (
                                    <div key={cls.id} style={{ display: 'flex', gap: '12px', alignItems: 'center' }}>
                                        <div style={{ width: '40px', height: '40px', borderRadius: '8px', background: '#eff6ff', display: 'flex', alignItems: 'center', justifyContent: 'center', flexShrink: 0 }}>
                                            <i className="bi bi-camera-video" style={{ color: '#2563eb' }}></i>
                                        </div>
                                        <div style={{ flex: 1, minWidth: 0 }}>
                                            <div style={{ fontSize: '13px', fontWeight: 700, color: '#1e293b', whiteSpace: 'nowrap', overflow: 'hidden', textOverflow: 'ellipsis' }}>{cls.title}</div>
                                            <div style={{ fontSize: '11px', color: '#64748b' }}>{cls.time}</div>
                                        </div>
                                    </div>
                                ))}
                             </div>
                        </div>
                    </div>
                </div>
            </div>
        </LmsLayout>
    );
}
