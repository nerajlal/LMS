import LmsLayout from '@/Layouts/LmsLayout';
import { Head, Link } from '@inertiajs/react';
import { useState } from 'react';

const card = {
    background: '#fff',
    borderRadius: '8px',
    boxShadow: '0 1px 3px rgba(0,0,0,0.08), 0 1px 2px rgba(0,0,0,0.05)',
    overflow: 'hidden',
    transition: 'transform 0.15s, box-shadow 0.15s',
};

const CourseCard = ({ course }) => (
    <div
        style={card}
        onMouseEnter={e => { e.currentTarget.style.transform = 'translateY(-3px)'; e.currentTarget.style.boxShadow = '0 8px 24px rgba(0,0,0,0.1)'; }}
        onMouseLeave={e => { e.currentTarget.style.transform = ''; e.currentTarget.style.boxShadow = '0 1px 3px rgba(0,0,0,0.08)'; }}
    >
        <div style={{ height: '150px', background: 'linear-gradient(135deg, #eff6ff, #dbeafe)', display: 'flex', alignItems: 'center', justifyContent: 'center', position: 'relative' }}>
            <i className="bi bi-play-circle" style={{ color: '#3b82f6', fontSize: '48px' }}></i>
            {course.price > 0 && (
                <span style={{ position: 'absolute', top: '10px', right: '10px', background: '#2563eb', color: '#fff', borderRadius: '4px', padding: '3px 8px', fontSize: '12px', fontWeight: 600 }}>
                    ₹{course.price?.toLocaleString()}
                </span>
            )}
        </div>
        <div style={{ padding: '14px' }}>
            <div style={{ color: '#1f2937', fontWeight: 600, fontSize: '14px', marginBottom: '4px', lineHeight: 1.4 }}>{course.title}</div>
            <div style={{ color: '#6b7280', fontSize: '12px', marginBottom: '12px' }}>
                <i className="bi bi-person me-1"></i> {course.instructor_name || 'Instructor'}
            </div>
            <Link href={route('courses.show', course.id)} style={{
                display: 'block', textAlign: 'center', padding: '8px',
                background: '#2563eb', color: '#fff', borderRadius: '6px',
                textDecoration: 'none', fontSize: '13px', fontWeight: 600,
            }}>View Course</Link>
        </div>
    </div>
);

export default function CoursesIndex({ auth, courses }) {
    const [search, setSearch] = useState('');
    const [category, setCategory] = useState('All');

    const allCourses = courses || [
        { id: 1, title: 'Full Stack Web Development', instructor_name: 'Prof. Rao', price: 12000 },
        { id: 2, title: 'Data Science & Machine Learning', instructor_name: 'Prof. Sharma', price: 15000 },
        { id: 3, title: 'UI/UX Design Principles', instructor_name: 'Prof. Nair', price: 8000 },
        { id: 4, title: 'Cloud Computing & DevOps', instructor_name: 'Prof. Kumar', price: 14000 },
        { id: 5, title: 'Mobile App Development', instructor_name: 'Prof. Menon', price: 11000 },
        { id: 6, title: 'Cybersecurity Fundamentals', instructor_name: 'Prof. Singh', price: 9000 },
    ];

    const categories = ['All', 'Web Dev', 'Data Science', 'Design', 'Cloud', 'Mobile'];
    const filtered = allCourses.filter(c => c.title.toLowerCase().includes(search.toLowerCase()));

    return (
        <LmsLayout title="Courses">
            <Head title="Courses" />

            {/* Header */}
            <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', marginBottom: '20px' }}>
                <div>
                    <h2 style={{ color: '#1f2937', fontSize: '20px', fontWeight: 700, margin: 0 }}>Explore Courses</h2>
                    <p style={{ color: '#6b7280', fontSize: '13px', margin: '4px 0 0 0' }}>Find the perfect course to advance your career</p>
                </div>
                <Link href={route('admissions.create')} style={{ padding: '9px 18px', background: '#2563eb', color: '#fff', borderRadius: '6px', textDecoration: 'none', fontSize: '13px', fontWeight: 600 }}>
                    <i className="bi bi-person-plus me-1"></i> Apply Now
                </Link>
            </div>

            {/* Search + Filter */}
            <div style={{ background: '#fff', borderRadius: '8px', boxShadow: '0 1px 3px rgba(0,0,0,0.08)', padding: '16px 20px', marginBottom: '20px', display: 'flex', alignItems: 'center', gap: '16px', flexWrap: 'wrap' }}>
                <div style={{ position: 'relative', flex: '1', minWidth: '200px' }}>
                    <i className="bi bi-search" style={{ position: 'absolute', left: '10px', top: '50%', transform: 'translateY(-50%)', color: '#9ca3af', fontSize: '13px' }}></i>
                    <input
                        type="text"
                        placeholder="Search courses..."
                        value={search}
                        onChange={e => setSearch(e.target.value)}
                        style={{ width: '100%', padding: '8px 10px 8px 32px', border: '1px solid #e5e7eb', borderRadius: '6px', fontSize: '13px', color: '#1f2937', outline: 'none' }}
                        onFocus={e => e.target.style.borderColor = '#3b82f6'}
                        onBlur={e => e.target.style.borderColor = '#e5e7eb'}
                    />
                </div>
                <div style={{ display: 'flex', gap: '8px', flexWrap: 'wrap' }}>
                    {categories.map(cat => (
                        <button key={cat} onClick={() => setCategory(cat)} style={{
                            padding: '7px 14px', borderRadius: '20px', fontSize: '12px', fontWeight: 500, cursor: 'pointer',
                            background: category === cat ? '#2563eb' : '#f3f4f6',
                            border: category === cat ? 'none' : '1px solid #e5e7eb',
                            color: category === cat ? '#fff' : '#6b7280',
                            transition: 'all 0.15s',
                        }}>
                            {cat}
                        </button>
                    ))}
                </div>
            </div>

            {/* Course Grid */}
            <div className="row g-3">
                {filtered.map(course => (
                    <div key={course.id} className="col-12 col-sm-6 col-md-4 col-xl-3">
                        <CourseCard course={course} />
                    </div>
                ))}
                {filtered.length === 0 && (
                    <div className="col-12" style={{ textAlign: 'center', padding: '60px', color: '#9ca3af' }}>
                        <i className="bi bi-search" style={{ fontSize: '40px', display: 'block', marginBottom: '10px' }}></i>
                        No courses found.
                    </div>
                )}
            </div>
        </LmsLayout>
    );
}
