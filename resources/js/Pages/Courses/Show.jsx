import LmsLayout from '@/Layouts/LmsLayout';
import { Head, Link } from '@inertiajs/react';
import { useState } from 'react';

const card = {
    background: '#fff',
    borderRadius: '8px',
    boxShadow: '0 1px 3px rgba(0,0,0,0.08), 0 1px 2px rgba(0,0,0,0.05)',
};

export default function CourseShow({ auth, course }) {
    const [activeTab, setActiveTab] = useState('overview');
    const c = course || {
        id: 1,
        title: 'Full Stack Web Development',
        description: 'A comprehensive course covering everything from HTML/CSS basics to advanced React, Node.js, and database management. Industry-ready full stack development skills.',
        instructor_name: 'Prof. Rao',
        price: 12000,
        lessons: [
            { id: 1, title: 'Introduction to HTML & CSS', video_url: 'https://www.youtube.com/embed/UB1O30fR-EE', order: 1 },
            { id: 2, title: 'JavaScript Fundamentals', video_url: 'https://www.youtube.com/embed/W6NZfCO5SIk', order: 2 },
            { id: 3, title: 'React for Beginners', video_url: 'https://www.youtube.com/embed/Ke90Tje7VS0', order: 3 },
        ],
    };
    const [activeLesson, setActiveLesson] = useState(c.lessons?.[0] || null);

    return (
        <LmsLayout title={c.title}>
            <Head title={c.title} />
            <div className="row g-4">
                {/* Main */}
                <div className="col-12 col-lg-8">
                    {/* Video */}
                    {activeLesson && (
                        <div style={{ ...card, marginBottom: '20px', overflow: 'hidden' }}>
                            <iframe
                                src={activeLesson.video_url}
                                title={activeLesson.title}
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowFullScreen
                                style={{ width: '100%', height: '380px', border: 'none', display: 'block' }}
                            ></iframe>
                        </div>
                    )}

                    {/* Course info */}
                    <div style={{ ...card, padding: '20px' }}>
                        <h1 style={{ color: '#1f2937', fontSize: '20px', fontWeight: 700, marginBottom: '6px' }}>{c.title}</h1>
                        <div style={{ color: '#6b7280', fontSize: '13px', marginBottom: '16px' }}>
                            <i className="bi bi-person-circle me-1"></i> {c.instructor_name}
                        </div>

                        {/* Tabs */}
                        <div style={{ borderBottom: '1px solid #e5e7eb', marginBottom: '20px', display: 'flex', gap: '0' }}>
                            {['overview', 'curriculum', 'materials'].map(tab => (
                                <button key={tab} onClick={() => setActiveTab(tab)} style={{
                                    padding: '10px 16px', background: 'transparent', border: 'none', cursor: 'pointer',
                                    color: activeTab === tab ? '#2563eb' : '#6b7280',
                                    fontWeight: activeTab === tab ? 600 : 400,
                                    textTransform: 'capitalize', fontSize: '13px',
                                    borderBottom: activeTab === tab ? '2px solid #2563eb' : '2px solid transparent',
                                    marginBottom: '-1px',
                                    transition: 'all 0.15s',
                                }}>
                                    {tab}
                                </button>
                            ))}
                        </div>

                        {activeTab === 'overview' && (
                            <p style={{ color: '#374151', fontSize: '14px', lineHeight: 1.8, margin: 0 }}>{c.description}</p>
                        )}

                        {activeTab === 'curriculum' && (
                            <div style={{ display: 'flex', flexDirection: 'column', gap: '8px' }}>
                                {c.lessons?.map((lesson, i) => (
                                    <button key={lesson.id} onClick={() => setActiveLesson(lesson)} style={{
                                        display: 'flex', alignItems: 'center', gap: '12px',
                                        padding: '12px 14px', borderRadius: '6px', cursor: 'pointer', textAlign: 'left',
                                        background: activeLesson?.id === lesson.id ? '#eff6ff' : '#f9fafb',
                                        border: activeLesson?.id === lesson.id ? '1px solid #bfdbfe' : '1px solid #e5e7eb',
                                        transition: 'all 0.15s',
                                    }}>
                                        <div style={{ width: '28px', height: '28px', borderRadius: '50%', background: activeLesson?.id === lesson.id ? '#2563eb' : '#e5e7eb', display: 'flex', alignItems: 'center', justifyContent: 'center', flexShrink: 0 }}>
                                            <i className="bi bi-play-fill" style={{ color: activeLesson?.id === lesson.id ? '#fff' : '#9ca3af', fontSize: '11px' }}></i>
                                        </div>
                                        <span style={{ color: '#1f2937', fontSize: '13px', fontWeight: 500 }}>Lesson {i + 1}: {lesson.title}</span>
                                    </button>
                                ))}
                            </div>
                        )}

                        {activeTab === 'materials' && (
                            <div style={{ display: 'flex', flexDirection: 'column', gap: '8px' }}>
                                {['Week 1 Notes.pdf', 'Week 2 Assignments.pdf', 'Reference Book.pdf'].map((f, i) => (
                                    <div key={i} style={{ display: 'flex', alignItems: 'center', gap: '12px', padding: '12px 14px', borderRadius: '6px', background: '#f9fafb', border: '1px solid #e5e7eb' }}>
                                        <i className="bi bi-file-earmark-pdf-fill" style={{ color: '#ef4444', fontSize: '20px' }}></i>
                                        <span style={{ color: '#1f2937', fontSize: '13px', flex: 1 }}>{f}</span>
                                        <a href="#" style={{ padding: '5px 12px', background: '#eff6ff', border: '1px solid #bfdbfe', color: '#2563eb', borderRadius: '5px', fontSize: '12px', textDecoration: 'none', fontWeight: 500 }}>
                                            <i className="bi bi-download me-1"></i> Download
                                        </a>
                                    </div>
                                ))}
                            </div>
                        )}
                    </div>
                </div>

                {/* Sidebar */}
                <div className="col-12 col-lg-4">
                    <div style={{ ...card, padding: '20px', position: 'sticky', top: '80px' }}>
                        <div style={{ color: '#1f2937', fontSize: '26px', fontWeight: 700, marginBottom: '4px' }}>₹{c.price?.toLocaleString()}</div>
                        <div style={{ color: '#6b7280', fontSize: '12px', marginBottom: '16px' }}>One-time payment · Lifetime access</div>

                        <Link href={route('admissions.create')} style={{
                            display: 'block', textAlign: 'center', padding: '12px',
                            background: '#2563eb', color: '#fff', borderRadius: '6px',
                            textDecoration: 'none', fontSize: '14px', fontWeight: 600, marginBottom: '10px',
                        }}>Enroll Now</Link>

                        <a href="#" style={{ display: 'block', textAlign: 'center', padding: '10px', background: '#f3f4f6', border: '1px solid #e5e7eb', color: '#374151', borderRadius: '6px', textDecoration: 'none', fontSize: '13px' }}>
                            <i className="bi bi-whatsapp me-1"></i> Contact Us
                        </a>

                        <hr style={{ borderColor: '#e5e7eb', margin: '16px 0' }} />

                        <div style={{ display: 'flex', flexDirection: 'column', gap: '10px' }}>
                            {[
                                { icon: 'bi-camera-video', text: 'Weekly live classes (Zoom)' },
                                { icon: 'bi-play-circle', text: 'Recorded video lessons (YouTube)' },
                                { icon: 'bi-file-earmark-text', text: 'Study materials & PDFs' },
                                { icon: 'bi-patch-check', text: 'Certificate on completion' },
                            ].map((f, i) => (
                                <div key={i} style={{ display: 'flex', alignItems: 'center', gap: '8px', color: '#374151', fontSize: '13px' }}>
                                    <i className={`bi ${f.icon}`} style={{ color: '#3b82f6', fontSize: '15px', width: '18px', textAlign: 'center' }}></i>
                                    {f.text}
                                </div>
                            ))}
                        </div>
                    </div>
                </div>
            </div>
        </LmsLayout>
    );
}
