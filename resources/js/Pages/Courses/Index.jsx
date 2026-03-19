import LmsLayout from '@/Layouts/LmsLayout';
import { Head, Link } from '@inertiajs/react';
import { useState } from 'react';

const cardStyle = {
    background: '#fff',
    borderRadius: '16px',
    boxShadow: '0 1px 3px rgba(0,0,0,0.05), 0 1px 2px rgba(0,0,0,0.02)',
    overflow: 'hidden',
    transition: 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)',
    border: '1px solid #f1f5f9',
};

const CourseCard = ({ course }) => (
    <div
        className="h-100 d-flex flex-column"
        style={cardStyle}
        onMouseEnter={e => { 
            e.currentTarget.style.transform = 'translateY(-6px)'; 
            e.currentTarget.style.boxShadow = '0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04)'; 
            e.currentTarget.style.borderColor = '#e2e8f0';
        }}
        onMouseLeave={e => { 
            e.currentTarget.style.transform = ''; 
            e.currentTarget.style.boxShadow = cardStyle.boxShadow; 
            e.currentTarget.style.borderColor = '#f1f5f9';
        }}
    >
        <Link href={route('courses.show', course.id)} style={{ textDecoration: 'none' }}>
            <div style={{ height: '180px', background: 'linear-gradient(135deg, #f8fafc, #eff6ff)', display: 'flex', alignItems: 'center', justifyContent: 'center', position: 'relative', overflow: 'hidden' }}>
                <i className="bi bi-play-circle-fill" style={{ color: '#2563eb', fontSize: '56px', opacity: 0.9 }}></i>
                {course.price > 0 ? (
                    <span style={{ position: 'absolute', bottom: '12px', right: '12px', background: '#fff', color: '#1e293b', borderRadius: '8px', padding: '4px 10px', fontSize: '14px', fontWeight: 800, boxShadow: '0 4px 6px rgba(0,0,0,0.05)' }}>
                        ₹{course.price?.toLocaleString()}
                    </span>
                ) : (
                    <span style={{ position: 'absolute', bottom: '12px', right: '12px', background: '#10b981', color: '#fff', borderRadius: '8px', padding: '4px 10px', fontSize: '12px', fontWeight: 800 }}>
                        FREE
                    </span>
                )}
                <div style={{ position: 'absolute', top: '12px', left: '12px' }}>
                    <span style={{ background: 'rgba(30, 41, 59, 0.7)', backdropFilter: 'blur(4px)', color: '#fff', borderRadius: '6px', padding: '2px 8px', fontSize: '10px', fontWeight: 700, textTransform: 'uppercase' }}>
                        {course.lessons_count || 0} Lessons
                    </span>
                </div>
            </div>
        </Link>
        
        <div style={{ padding: '20px', flex: 1, display: 'flex', flexDirection: 'column' }}>
            <div style={{ display: 'flex', gap: '4px', marginBottom: '8px' }}>
                {[1, 2, 3, 4, 5].map(s => (
                    <i key={s} className="bi bi-star-fill" style={{ color: '#f59e0b', fontSize: '12px' }}></i>
                ))}
                <span style={{ fontSize: '12px', color: '#64748b', fontWeight: 600, marginLeft: '4px' }}>(4.9)</span>
            </div>
            
            <Link href={route('courses.show', course.id)} style={{ textDecoration: 'none', color: '#1e293b' }}>
                <h3 style={{ fontWeight: 800, fontSize: '16px', marginBottom: '6px', lineHeight: 1.5, height: '48px', overflow: 'hidden', display: '-webkit-box', WebkitLineClamp: 2, WebkitBoxOrient: 'vertical' }}>
                    {course.title}
                </h3>
            </Link>
            
            <div style={{ color: '#64748b', fontSize: '13px', marginBottom: '16px' }}>
                <i className="bi bi-person-circle me-2"></i> {course.instructor_name || 'Expert Instructor'}
            </div>
            
            <div style={{ mt: 'auto', pt: '16px', borderTop: '1px solid #f1f5f9', display: 'flex', alignItems: 'center', justifyContent: 'space-between' }}>
                <div style={{ display: 'flex', alignItems: 'center', gap: '4px', color: '#64748b', fontSize: '12px', fontWeight: 600 }}>
                    <i className="bi bi-people-fill" style={{ color: '#3b82f6' }}></i>
                    <span>{course.enrollments_count || 0} students</span>
                </div>
                <div style={{ color: '#64748b', fontSize: '12px', fontWeight: 600 }}>
                    <i className="bi bi-clock-fill me-1" style={{ color: '#3b82f6' }}></i> 12h 30m
                </div>
            </div>
        </div>
    </div>
);

export default function CoursesIndex({ auth, courses }) {
    const [search, setSearch] = useState('');
    const [activeCategory, setActiveCategory] = useState('All');

    const categories = ['All', 'Web Development', 'Data Science', 'UI/UX Design', 'Cloud & DevOps', 'Business'];
    
    const filtered = (courses || []).filter(c => 
        c.title.toLowerCase().includes(search.toLowerCase())
    );

    return (
        <LmsLayout title="Explore Courses">
            <Head title="Browse Courses" />

            {/* Hero Section */}
            <div style={{
                background: 'linear-gradient(135deg, #1e293b 0%, #0f172a 100%)',
                borderRadius: '24px',
                padding: '48px 48px',
                marginBottom: '40px',
                color: '#fff',
                position: 'relative',
                overflow: 'hidden',
                boxShadow: '0 20px 25px -5px rgba(0, 0, 0, 0.1)',
            }}>
                <div style={{ position: 'absolute', right: '-10%', top: '-20%', width: '400px', height: '400px', background: 'radial-gradient(circle, rgba(37,99,235,0.15) 0%, transparent 70%)', borderRadius: '50%' }}></div>
                <div style={{ position: 'relative', zIndex: 1, maxWidth: '600px' }}>
                    <h2 style={{ fontSize: '36px', fontWeight: 900, marginBottom: '16px', letterSpacing: '-1px' }}>Master New Skills with Our Premium Courses</h2>
                    <p style={{ fontSize: '18px', opacity: 0.8, marginBottom: '32px', lineHeight: 1.6 }}>
                        Join over 12,000+ students worldwide and start your learning journey today. Get access to industry-recognized certifications.
                    </p>
                    <div style={{ display: 'flex', gap: '16px' }}>
                        <Link href={route('admissions.create')} style={{ 
                            background: '#2563eb', color: '#fff', padding: '14px 28px', 
                            borderRadius: '12px', textDecoration: 'none', fontWeight: 700, fontSize: '16px',
                            boxShadow: '0 10px 15px -3px rgba(37,99,235,0.4)', transition: 'all 0.2s'
                        }}
                        onMouseEnter={e => e.currentTarget.style.transform = 'translateY(-2px)'}
                        onMouseLeave={e => e.currentTarget.style.transform = ''}
                        >
                            Get Started Now
                        </Link>
                        <div style={{ display: 'flex', alignItems: 'center', gap: '12px' }}>
                            <div style={{ display: 'flex', marginLeft: '8px' }}>
                                {[1,2,3,4].map(i => (
                                    <div key={i} style={{ width: '32px', height: '32px', borderRadius: '50%', border: '2px solid #1e293b', background: '#3b82f6', marginLeft: '-12px', display: 'flex', alignItems: 'center', justifyContent: 'center', fontSize: '10px', fontWeight: 700 }}>
                                        {String.fromCharCode(64 + i)}
                                    </div>
                                ))}
                            </div>
                            <span style={{ fontSize: '14px', fontWeight: 600, opacity: 0.9 }}>1.2k+ reviews</span>
                        </div>
                    </div>
                </div>
            </div>

            {/* Filter Bar */}
            <div style={{ 
                background: '#fff', borderRadius: '16px', padding: '12px 24px', 
                marginBottom: '40px', display: 'flex', alignItems: 'center', 
                justifyContent: 'space-between', gap: '20px', flexWrap: 'wrap',
                border: '1px solid #f1f5f9', boxShadow: '0 4px 6px -1px rgba(0, 0, 0, 0.05)'
            }}>
                <div style={{ display: 'flex', gap: '8px', overflowX: 'auto', padding: '4px 0', WebkitOverflowScrolling: 'touch' }}>
                    {categories.map(cat => (
                        <button 
                            key={cat} 
                            onClick={() => setActiveCategory(cat)} 
                            style={{
                                padding: '8px 18px', borderRadius: '10px', fontSize: '14px', fontWeight: 700, cursor: 'pointer',
                                background: activeCategory === cat ? '#2563eb' : 'transparent',
                                border: 'none',
                                color: activeCategory === cat ? '#fff' : '#64748b',
                                transition: 'all 0.2s',
                                whiteSpace: 'nowrap'
                            }}
                        >
                            {cat}
                        </button>
                    ))}
                </div>
                
                <div style={{ position: 'relative', minWidth: '280px' }}>
                    <i className="bi bi-search" style={{ position: 'absolute', left: '14px', top: '50%', transform: 'translateY(-50%)', color: '#94a3b8', fontSize: '14px' }}></i>
                    <input
                        type="text"
                        placeholder="Search for courses, experts..."
                        value={search}
                        onChange={e => setSearch(e.target.value)}
                        style={{ 
                            width: '100%', padding: '10px 16px 10px 42px', 
                            background: '#f8fafc', border: '1px solid #f1f5f9', 
                            borderRadius: '12px', fontSize: '14px', color: '#1e293b', outline: 'none' 
                        }}
                    />
                </div>
            </div>

            {/* Course Grid */}
            <div className="row g-4 mb-5">
                {filtered.map(course => (
                    <div key={course.id} className="col-12 col-md-6 col-lg-4 col-xl-3">
                        <CourseCard course={course} />
                    </div>
                ))}
                
                {filtered.length === 0 && (
                    <div className="col-12">
                        <div style={{ textAlign: 'center', padding: '80px 40px', background: '#fff', borderRadius: '24px', border: '2px dashed #e2e8f0' }}>
                            <div style={{ width: '80px', height: '80px', background: '#f8fafc', borderRadius: '50%', display: 'flex', alignItems: 'center', justifyContent: 'center', margin: '0 auto 24px' }}>
                                <i className="bi bi-search" style={{ fontSize: '32px', color: '#94a3b8' }}></i>
                            </div>
                            <h3 style={{ fontSize: '20px', fontWeight: 800, color: '#1e293b', marginBottom: '8px' }}>No courses found</h3>
                            <p style={{ color: '#64748b', fontSize: '15px' }}>We couldn't find any courses matching your search "{search}".</p>
                            <button onClick={() => setSearch('')} style={{ mt: '16px', background: '#f1f5f9', border: 'none', padding: '10px 24px', borderRadius: '10px', color: '#475569', fontWeight: 700 }}>
                                Clear Search
                            </button>
                        </div>
                    </div>
                )}
            </div>
        </LmsLayout>
    );
}
