import AdminLayout from '@/Layouts/AdminLayout';
import { Head, Link, router } from '@inertiajs/react';

export default function AdminCoursesIndex({ courses }) {
    const handleDelete = (id) => {
        if (confirm('Are you sure you want to delete this course?')) {
            router.delete(route('admin.courses.destroy', id));
        }
    };

    return (
        <AdminLayout title="Manage Courses">
            <Head title="Admin — Courses" />

            <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', marginBottom: '20px' }}>
                <div>
                    <h1 style={{ margin: 0, fontSize: '20px', fontWeight: 700, color: '#1f2937' }}>Courses</h1>
                    <p style={{ margin: '2px 0 0', color: '#6b7280', fontSize: '14px' }}>{courses?.total ?? 0} total courses</p>
                </div>
                <Link href={route('admin.courses.create')} style={{
                    background: 'linear-gradient(135deg, #e3000f, #cc0000)', color: '#fff',
                    padding: '9px 18px', borderRadius: '8px', textDecoration: 'none',
                    fontWeight: 600, fontSize: '14px', display: 'inline-flex', alignItems: 'center', gap: '6px',
                }}>
                    <i className="bi bi-plus-lg"></i> Add Course
                </Link>
            </div>

            <div style={{ background: '#fff', borderRadius: '12px', boxShadow: '0 1px 4px rgba(0,0,0,0.08)', overflow: 'hidden' }}>
                <div style={{ overflowX: 'auto' }}>
                    <table style={{ width: '100%', borderCollapse: 'collapse', fontSize: '14px' }}>
                        <thead>
                            <tr style={{ background: '#f9fafb' }}>
                                {['#', 'Title', 'Instructor', 'Price', 'Lessons', 'Admissions', 'Actions'].map(h => (
                                    <th key={h} style={{ padding: '12px 16px', textAlign: 'left', fontWeight: 600, color: '#6b7280', fontSize: '12px', textTransform: 'uppercase', letterSpacing: '0.04em', whiteSpace: 'nowrap' }}>{h}</th>
                                ))}
                            </tr>
                        </thead>
                        <tbody>
                            {(courses?.data || []).length === 0 ? (
                                <tr><td colSpan="7" style={{ padding: '32px', textAlign: 'center', color: '#9ca3af' }}>
                                    No courses yet. <Link href={route('admin.courses.create')} style={{ color: '#e3000f' }}>Add your first course</Link>.
                                </td></tr>
                            ) : (
                                courses.data.map((course, i) => (
                                    <tr key={course.id} style={{ borderTop: '1px solid #f3f4f6' }}
                                        onMouseEnter={e => e.currentTarget.style.background = '#fafafa'}
                                        onMouseLeave={e => e.currentTarget.style.background = 'transparent'}
                                    >
                                        <td style={{ padding: '12px 16px', color: '#9ca3af', fontSize: '13px' }}>{i + 1}</td>
                                        <td style={{ padding: '12px 16px' }}>
                                            <div style={{ fontWeight: 600, color: '#1f2937' }}>{course.title}</div>
                                            <div style={{ fontSize: '12px', color: '#9ca3af', marginTop: '2px' }}>{course.description?.substring(0, 50)}...</div>
                                        </td>
                                        <td style={{ padding: '12px 16px', color: '#6b7280' }}>{course.instructor_name}</td>
                                        <td style={{ padding: '12px 16px', fontWeight: 600, color: '#1f2937' }}>₹{parseFloat(course.price).toLocaleString()}</td>
                                        <td style={{ padding: '12px 16px', color: '#6b7280' }}>{course.lessons_count ?? 0}</td>
                                        <td style={{ padding: '12px 16px', color: '#6b7280' }}>{course.admissions_count ?? 0}</td>
                                        <td style={{ padding: '12px 16px' }}>
                                            <div style={{ display: 'flex', gap: '6px' }}>
                                                <Link href={route('admin.courses.edit', course.id)} style={{
                                                    background: '#eff6ff', color: '#cc0000', border: 'none',
                                                    padding: '5px 12px', borderRadius: '6px', fontSize: '12px', fontWeight: 600, textDecoration: 'none',
                                                }}>
                                                    <i className="bi bi-pencil me-1"></i>Edit
                                                </Link>
                                                <button onClick={() => handleDelete(course.id)} style={{
                                                    background: '#fee2e2', color: '#dc2626', border: 'none',
                                                    padding: '5px 12px', borderRadius: '6px', fontSize: '12px', fontWeight: 600, cursor: 'pointer',
                                                }}>
                                                    <i className="bi bi-trash me-1"></i>Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                ))
                            )}
                        </tbody>
                    </table>
                </div>

                {/* Pagination */}
                {courses?.last_page > 1 && (
                    <div style={{ padding: '16px 20px', borderTop: '1px solid #f3f4f6', display: 'flex', gap: '8px' }}>
                        {courses.links?.map((link, i) => (
                            <Link key={i} href={link.url || '#'} style={{
                                padding: '5px 12px', borderRadius: '6px', fontSize: '13px', textDecoration: 'none',
                                background: link.active ? '#e3000f' : '#f3f4f6',
                                color: link.active ? '#fff' : '#6b7280',
                            }} dangerouslySetInnerHTML={{ __html: link.label }} />
                        ))}
                    </div>
                )}
            </div>
        </AdminLayout>
    );
}
