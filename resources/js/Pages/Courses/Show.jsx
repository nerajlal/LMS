import LmsLayout from '@/Layouts/LmsLayout';
import { Head, Link } from '@inertiajs/react';
import { useState } from 'react';

export default function CourseShow({ auth, course }) {
    const [activeTab, setActiveTab] = useState('overview');

    const c = course || {
        id: 1,
        title: 'Full Stack Web Development',
        description: 'A comprehensive course covering everything from HTML/CSS basics to advanced React, Node.js, and database management. This course is designed for students who want to become industry-ready full stack developers.',
        instructor_name: 'Prof. Rao',
        price: 12000,
        lessons: [
            { id: 1, title: 'Introduction to HTML & CSS', video_url: 'https://www.youtube.com/embed/UB1O30fR-EE', order: 1 },
            { id: 2, title: 'JavaScript Fundamentals', video_url: 'https://www.youtube.com/embed/W6NZfCO5SIk', order: 2 },
            { id: 3, title: 'React for Beginners', video_url: 'https://www.youtube.com/embed/Ke90Tje7VS0', order: 3 },
        ],
    };

    const [activeLesson, setActiveLesson] = useState(c.lessons?.[0] || null);

    const tabs = ['overview', 'curriculum', 'materials'];

    return (
        <LmsLayout>
            <Head title={c.title} />

            <div className="row g-4">
                {/* Main Content */}
                <div className="col-12 col-lg-8">
                    {/* Video Player */}
                    {activeLesson && (
                        <div style={{ borderRadius: '16px', overflow: 'hidden', marginBottom: '24px', background: '#000', boxShadow: '0 20px 60px rgba(0,0,0,0.5)' }}>
                            <iframe
                                src={activeLesson.video_url}
                                title={activeLesson.title}
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowFullScreen
                                style={{ width: '100%', height: '400px', border: 'none', display: 'block' }}
                            ></iframe>
                        </div>
                    )}

                    {/* Course Title */}
                    <h1 style={{ color: '#fff', fontSize: '22px', fontWeight: 700, marginBottom: '6px' }}>{c.title}</h1>
                    <div style={{ color: 'rgba(255,255,255,0.5)', fontSize: '14px', marginBottom: '20px' }}>
                        <i className="bi bi-person-circle me-1"></i> {c.instructor_name}
                    </div>

                    {/* Tabs */}
                    <div style={{ borderBottom: '1px solid rgba(255,255,255,0.08)', marginBottom: '24px', display: 'flex', gap: '4px' }}>
                        {tabs.map(tab => (
                            <button key={tab} onClick={() => setActiveTab(tab)} style={{
                                padding: '10px 18px', background: 'transparent', border: 'none', cursor: 'pointer',
                                color: activeTab === tab ? '#7c3aed' : 'rgba(255,255,255,0.5)',
                                fontWeight: activeTab === tab ? 700 : 400,
                                textTransform: 'capitalize', fontSize: '14px',
                                borderBottom: activeTab === tab ? '2px solid #7c3aed' : '2px solid transparent',
                                transition: 'all 0.2s',
                            }}>
                                {tab}
                            </button>
                        ))}
                    </div>

                    {activeTab === 'overview' && (
                        <div style={{ color: 'rgba(255,255,255,0.7)', fontSize: '14px', lineHeight: 1.8 }}>
                            {c.description}
                        </div>
                    )}

                    {activeTab === 'curriculum' && (
                        <div className="d-flex flex-column gap-2">
                            {c.lessons?.map((lesson, i) => (
                                <button key={lesson.id} onClick={() => setActiveLesson(lesson)} style={{
                                    display: 'flex', alignItems: 'center', gap: '12px',
                                    padding: '14px 16px', borderRadius: '12px', cursor: 'pointer', textAlign: 'left',
                                    background: activeLesson?.id === lesson.id ? 'rgba(124,58,237,0.15)' : 'rgba(255,255,255,0.04)',
                                    border: activeLesson?.id === lesson.id ? '1px solid rgba(124,58,237,0.4)' : '1px solid rgba(255,255,255,0.08)',
                                    transition: 'all 0.2s',
                                }}>
                                    <div style={{ width: '32px', height: '32px', borderRadius: '8px', background: activeLesson?.id === lesson.id ? '#7c3aed' : 'rgba(255,255,255,0.08)', display: 'flex', alignItems: 'center', justifyContent: 'center', flexShrink: 0 }}>
                                        <i className="bi bi-play-fill" style={{ color: activeLesson?.id === lesson.id ? '#fff' : 'rgba(255,255,255,0.5)', fontSize: '12px' }}></i>
                                    </div>
                                    <div>
                                        <div style={{ color: '#fff', fontSize: '14px', fontWeight: 500 }}>Lesson {i + 1}: {lesson.title}</div>
                                    </div>
                                </button>
                            ))}
                        </div>
                    )}

                    {activeTab === 'materials' && (
                        <div className="d-flex flex-column gap-2">
                            {['Week 1 Notes.pdf', 'Week 2 Assignments.pdf', 'Reference Book.pdf'].map((f, i) => (
                                <div key={i} style={{ display: 'flex', alignItems: 'center', gap: '12px', padding: '14px 16px', borderRadius: '12px', background: 'rgba(255,255,255,0.04)', border: '1px solid rgba(255,255,255,0.08)' }}>
                                    <i className="bi bi-file-earmark-pdf-fill" style={{ color: '#ef4444', fontSize: '22px' }}></i>
                                    <span style={{ color: '#fff', fontSize: '14px', flex: 1 }}>{f}</span>
                                    <a href="#" style={{ padding: '6px 14px', background: 'rgba(124,58,237,0.15)', border: '1px solid rgba(124,58,237,0.3)', color: '#7c3aed', borderRadius: '8px', fontSize: '12px', textDecoration: 'none' }}>
                                        <i className="bi bi-download me-1"></i> Download
                                    </a>
                                </div>
                            ))}
                        </div>
                    )}
                </div>

                {/* Sidebar */}
                <div className="col-12 col-lg-4">
                    <div style={{ background: 'rgba(255,255,255,0.04)', border: '1px solid rgba(255,255,255,0.08)', borderRadius: '16px', padding: '24px', position: 'sticky', top: '80px' }}>
                        <div style={{ color: '#fff', fontSize: '28px', fontWeight: 800, marginBottom: '4px' }}>₹{c.price?.toLocaleString()}</div>
                        <div style={{ color: 'rgba(255,255,255,0.5)', fontSize: '13px', marginBottom: '20px' }}>One-time payment · Lifetime access</div>

                        <Link
                            href={route('admissions.create')}
                            style={{
                                display: 'block', textAlign: 'center', padding: '14px',
                                background: 'linear-gradient(90deg, #7c3aed, #4f46e5)',
                                color: '#fff', borderRadius: '12px', textDecoration: 'none',
                                fontSize: '15px', fontWeight: 700, marginBottom: '12px',
                            }}
                        >
                            Enroll Now
                        </Link>
                        <a href="#" style={{ display: 'block', textAlign: 'center', padding: '12px', background: 'rgba(255,255,255,0.07)', border: '1px solid rgba(255,255,255,0.12)', color: 'rgba(255,255,255,0.7)', borderRadius: '12px', textDecoration: 'none', fontSize: '14px' }}>
                            <i className="bi bi-whatsapp me-1"></i> Contact Us
                        </a>

                        <hr style={{ borderColor: 'rgba(255,255,255,0.08)', margin: '20px 0' }} />

                        <div className="d-flex flex-column gap-2">
                            {[
                                { icon: 'bi-camera-video', text: 'Live classes every week' },
                                { icon: 'bi-play-circle', text: 'Recorded video lessons' },
                                { icon: 'bi-file-earmark-text', text: 'Study materials & PDFs' },
                                { icon: 'bi-patch-check', text: 'Certificate on completion' },
                            ].map((f, i) => (
                                <div key={i} style={{ display: 'flex', alignItems: 'center', gap: '10px', color: 'rgba(255,255,255,0.65)', fontSize: '13px' }}>
                                    <i className={`bi ${f.icon}`} style={{ color: '#7c3aed' }}></i> {f.text}
                                </div>
                            ))}
                        </div>
                    </div>
                </div>
            </div>
        </LmsLayout>
    );
}
