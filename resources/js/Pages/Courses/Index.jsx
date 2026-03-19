import LmsLayout from '@/Layouts/LmsLayout';
import { Head, Link } from '@inertiajs/react';
import { useState } from 'react';

const CourseCard = ({ course }) => (
    <div style={{
        background: 'rgba(255,255,255,0.04)',
        border: '1px solid rgba(255,255,255,0.08)',
        borderRadius: '16px',
        overflow: 'hidden',
        transition: 'transform 0.2s, box-shadow 0.2s',
    }}
        onMouseEnter={e => { e.currentTarget.style.transform = 'translateY(-4px)'; e.currentTarget.style.boxShadow = '0 12px 40px rgba(124,58,237,0.18)'; }}
        onMouseLeave={e => { e.currentTarget.style.transform = 'translateY(0)'; e.currentTarget.style.boxShadow = 'none'; }}
    >
        <div style={{ height: '160px', background: 'linear-gradient(135deg, #7c3aed33, #4f46e533)', display: 'flex', alignItems: 'center', justifyContent: 'center', position: 'relative' }}>
            <i className="bi bi-play-circle" style={{ color: '#7c3aed', fontSize: '52px' }}></i>
            {course.price > 0 && (
                <span style={{ position: 'absolute', top: '12px', right: '12px', background: 'linear-gradient(90deg, #7c3aed, #4f46e5)', color: '#fff', borderRadius: '8px', padding: '4px 10px', fontSize: '12px', fontWeight: 700 }}>
                    ₹{course.price}
                </span>
            )}
        </div>
        <div className="p-3">
            <div style={{ color: '#fff', fontWeight: 600, fontSize: '15px', marginBottom: '6px', lineHeight: 1.4 }}>{course.title}</div>
            <div style={{ color: 'rgba(255,255,255,0.5)', fontSize: '12px', marginBottom: '14px' }}>
                <i className="bi bi-person-circle me-1"></i> {course.instructor_name || 'Instructor'}
            </div>
            <div style={{ display: 'flex', gap: '8px' }}>
                <Link href={route('courses.show', course.id)} style={{
                    flex: 1, textAlign: 'center', padding: '9px',
                    background: 'linear-gradient(90deg, #7c3aed, #4f46e5)',
                    color: '#fff', borderRadius: '9px', textDecoration: 'none',
                    fontSize: '13px', fontWeight: 600,
                }}>View Course</Link>
            </div>
        </div>
    </div>
);

export default function CoursesIndex({ auth, courses }) {
    const [search, setSearch] = useState('');
    const [category, setCategory] = useState('All');

    const allCourses = courses || [
        { id: 1, title: 'Full Stack Web Development', instructor_name: 'Prof. Rao', price: 12000, description: 'A comprehensive course covering React, Node.js, and more.' },
        { id: 2, title: 'Data Science & Machine Learning', instructor_name: 'Prof. Sharma', price: 15000, description: 'Learn Python, Pandas, TensorFlow and real-world ML.' },
        { id: 3, title: 'UI/UX Design Principles', instructor_name: 'Prof. Nair', price: 8000 },
        { id: 4, title: 'Cloud Computing & DevOps', instructor_name: 'Prof. Kumar', price: 14000 },
        { id: 5, title: 'Mobile App Development', instructor_name: 'Prof. Menon', price: 11000 },
        { id: 6, title: 'Cybersecurity Fundamentals', instructor_name: 'Prof. Singh', price: 9000 },
    ];

    const categories = ['All', 'Web Dev', 'Data Science', 'Design', 'Cloud', 'Mobile', 'Security'];

    const filtered = allCourses.filter(c =>
        c.title.toLowerCase().includes(search.toLowerCase())
    );

    return (
        <LmsLayout>
            <Head title="Courses" />

            {/* Header */}
            <div className="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h1 style={{ color: '#fff', fontSize: '24px', fontWeight: 700, margin: 0 }}>Explore Courses</h1>
                    <p style={{ color: 'rgba(255,255,255,0.5)', fontSize: '14px', margin: '4px 0 0 0' }}>Find the perfect course to advance your career</p>
                </div>
                <Link href={route('admissions.create')} style={{
                    padding: '10px 20px', background: 'linear-gradient(90deg, #7c3aed, #4f46e5)',
                    color: '#fff', borderRadius: '10px', textDecoration: 'none', fontSize: '14px', fontWeight: 600,
                }}>
                    <i className="bi bi-person-plus me-2"></i>Apply Now
                </Link>
            </div>

            {/* Search & Filter */}
            <div className="d-flex flex-wrap gap-3 mb-4 align-items-center">
                <div style={{ position: 'relative', flex: '1', minWidth: '220px' }}>
                    <i className="bi bi-search" style={{ position: 'absolute', left: '12px', top: '50%', transform: 'translateY(-50%)', color: 'rgba(255,255,255,0.4)', fontSize: '14px' }}></i>
                    <input
                        type="text"
                        placeholder="Search courses..."
                        value={search}
                        onChange={e => setSearch(e.target.value)}
                        style={{
                            width: '100%', background: 'rgba(255,255,255,0.07)', border: '1px solid rgba(255,255,255,0.1)',
                            borderRadius: '10px', color: '#fff', padding: '10px 12px 10px 36px', fontSize: '14px', outline: 'none',
                        }}
                    />
                </div>
                {/* Category slugs */}
                <div className="d-flex gap-2 flex-wrap">
                    {categories.map(cat => (
                        <button key={cat} onClick={() => setCategory(cat)} style={{
                            padding: '8px 16px', borderRadius: '100px', fontSize: '13px', fontWeight: 500, cursor: 'pointer',
                            background: category === cat ? 'linear-gradient(90deg, #7c3aed, #4f46e5)' : 'rgba(255,255,255,0.07)',
                            border: category === cat ? 'none' : '1px solid rgba(255,255,255,0.1)',
                            color: category === cat ? '#fff' : 'rgba(255,255,255,0.6)',
                            transition: 'all 0.2s',
                        }}>
                            {cat}
                        </button>
                    ))}
                </div>
            </div>

            {/* Course Grid */}
            <div className="row g-4">
                {filtered.map(course => (
                    <div key={course.id} className="col-12 col-sm-6 col-md-4 col-xl-3">
                        <CourseCard course={course} />
                    </div>
                ))}
                {filtered.length === 0 && (
                    <div className="col-12 text-center py-5" style={{ color: 'rgba(255,255,255,0.4)' }}>
                        <i className="bi bi-search" style={{ fontSize: '48px', display: 'block', marginBottom: '12px' }}></i>
                        No courses found matching your search.
                    </div>
                )}
            </div>
        </LmsLayout>
    );
}
