import LmsLayout from '@/Layouts/LmsLayout';
import { Head, Link } from '@inertiajs/react';

export default function TrainerCoursesIndex({ courses }) {
    return (
        <LmsLayout title="My Assigned Courses">
            <Head title="My Courses - Trainer" />
            <div className="d-flex justify-content-between align-items-center mb-4">
                <h1 style={{ fontSize: '24px', fontWeight: 800, color: '#1e293b', margin: 0 }}>My Assigned Courses</h1>
            </div>
            
            {courses.length === 0 ? (
                <div style={{ background: '#fff', padding: '48px', borderRadius: '12px', textAlign: 'center', border: '1px solid #f1f5f9' }}>
                    <div style={{ width: '64px', height: '64px', borderRadius: '50%', background: '#fef2f2', color: '#e3000f', display: 'flex', alignItems: 'center', justifyContent: 'center', margin: '0 auto 16px' }}>
                        <i className="bi bi-journal-x" style={{ fontSize: '28px' }}></i>
                    </div>
                    <div style={{ color: '#1e293b', fontSize: '18px', fontWeight: 700, marginBottom: '8px' }}>No Courses Assigned</div>
                    <div style={{ color: '#64748b', fontSize: '14px' }}>You haven't been assigned to teach any courses yet. Contact the admin.</div>
                </div>
            ) : (
                <div className="row g-4">
                    {courses.map(course => (
                        <div key={course.id} className="col-12 col-md-6 col-xl-4">
                            <div style={{ background: '#fff', borderRadius: '16px', overflow: 'hidden', border: '1px solid #f1f5f9', display: 'flex', flexDirection: 'column', height: '100%', transition: 'transform 0.2s', boxShadow: '0 4px 6px -1px rgba(0,0,0,0.05)' }}>
                                <div style={{ height: '180px', background: course.thumbnail ? `url(${course.thumbnail}) center/cover` : 'linear-gradient(45deg, #1e293b, #0f172a)', position: 'relative' }}>
                                    <div style={{ position: 'absolute', top: '16px', right: '16px', background: 'rgba(0,0,0,0.6)', color: '#fff', padding: '4px 12px', borderRadius: '20px', fontSize: '12px', fontWeight: 600, backdropFilter: 'blur(4px)' }}>
                                        <i className="bi bi-play-circle me-1"></i> {course.lessons_count || 0} Lessons
                                    </div>
                                </div>
                                <div style={{ padding: '24px', display: 'flex', flexDirection: 'column', flex: 1 }}>
                                    <h3 style={{ fontSize: '18px', fontWeight: 800, color: '#1e293b', marginBottom: '8px' }}>{course.title}</h3>
                                    <p style={{ fontSize: '14px', color: '#64748b', marginBottom: '24px', flex: 1, display: '-webkit-box', WebkitLineClamp: 2, WebkitBoxOrient: 'vertical', overflow: 'hidden' }}>
                                        {course.description || "No description provided."}
                                    </p>
                                    <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', borderTop: '1px solid #f1f5f9', paddingTop: '16px', marginTop: 'auto' }}>
                                        <div style={{ fontSize: '13px', color: '#64748b', fontWeight: 600 }}>
                                            <i className="bi bi-people me-1"></i> {course.enrollments_count || 0} Students
                                        </div>
                                        <Link href={route('trainer.courses.show', course.id)} style={{ background: '#fef2f2', color: '#e3000f', padding: '8px 16px', borderRadius: '8px', textDecoration: 'none', fontWeight: 700, fontSize: '13px' }}>
                                            View Content
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    ))}
                </div>
            )}
        </LmsLayout>
    );
}
