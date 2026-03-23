import AdminLayout from '@/Layouts/AdminLayout';
import { Head, useForm, Link } from '@inertiajs/react';

export default function AdminCourseCreate({ course }) {
    const isEdit = !!course;
    const { data, setData, post, put, processing, errors } = useForm({
        title:           course?.title           || '',
        description:     course?.description     || '',
        thumbnail:       course?.thumbnail       || '',
        price:           course?.price           || '',
        instructor_name: course?.instructor_name || '',
    });

    const submit = (e) => {
        e.preventDefault();
        if (isEdit) {
            put(route('admin.courses.update', course.id));
        } else {
            post(route('admin.courses.store'));
        }
    };

    const inputStyle = {
        width: '100%', padding: '10px 14px', border: '1px solid #e5e7eb',
        borderRadius: '8px', fontSize: '14px', color: '#1f2937',
        outline: 'none', background: '#fff',
    };
    const labelStyle = { display: 'block', fontSize: '13px', fontWeight: 600, color: '#374151', marginBottom: '6px' };
    const errorStyle = { color: '#dc2626', fontSize: '12px', marginTop: '4px' };

    return (
        <AdminLayout title={isEdit ? 'Edit Course' : 'Add Course'}>
            <Head title={isEdit ? 'Edit Course' : 'Add Course'} />

            <div style={{ maxWidth: '680px', margin: '0 auto' }}>
                <div style={{ display: 'flex', alignItems: 'center', gap: '12px', marginBottom: '20px' }}>
                    <Link href={route('admin.courses.index')} style={{ color: '#e3000f', textDecoration: 'none', fontSize: '14px' }}>
                        <i className="bi bi-arrow-left me-1"></i> Back to Courses
                    </Link>
                </div>

                <div style={{ background: '#fff', borderRadius: '14px', boxShadow: '0 1px 4px rgba(0,0,0,0.08)', overflow: 'hidden' }}>
                    <div style={{ padding: '20px 24px', borderBottom: '1px solid #f3f4f6' }}>
                        <h1 style={{ margin: 0, fontSize: '18px', fontWeight: 700, color: '#1f2937' }}>
                            {isEdit ? 'Edit Course' : 'Add New Course'}
                        </h1>
                    </div>

                    <form onSubmit={submit} style={{ padding: '24px' }}>
                        <div style={{ marginBottom: '18px' }}>
                            <label style={labelStyle}>Course Title *</label>
                            <input
                                type="text" value={data.title} placeholder="e.g. Full Stack Web Development"
                                onChange={e => setData('title', e.target.value)} style={inputStyle}
                            />
                            {errors.title && <div style={errorStyle}>{errors.title}</div>}
                        </div>

                        <div style={{ marginBottom: '18px' }}>
                            <label style={labelStyle}>Description</label>
                            <textarea
                                value={data.description} rows={4} placeholder="Course description..."
                                onChange={e => setData('description', e.target.value)}
                                style={{ ...inputStyle, resize: 'vertical' }}
                            />
                            {errors.description && <div style={errorStyle}>{errors.description}</div>}
                        </div>

                        <div className="row g-3" style={{ marginBottom: '18px' }}>
                            <div className="col-md-6">
                                <label style={labelStyle}>Instructor Name *</label>
                                <input
                                    type="text" value={data.instructor_name} placeholder="e.g. Prof. Sharma"
                                    onChange={e => setData('instructor_name', e.target.value)} style={inputStyle}
                                />
                                {errors.instructor_name && <div style={errorStyle}>{errors.instructor_name}</div>}
                            </div>
                            <div className="col-md-6">
                                <label style={labelStyle}>Price (₹) *</label>
                                <input
                                    type="number" min="0" step="0.01" value={data.price} placeholder="e.g. 4999"
                                    onChange={e => setData('price', e.target.value)} style={inputStyle}
                                />
                                {errors.price && <div style={errorStyle}>{errors.price}</div>}
                            </div>
                        </div>

                        <div style={{ marginBottom: '24px' }}>
                            <label style={labelStyle}>Thumbnail URL</label>
                            <input
                                type="text" value={data.thumbnail} placeholder="https://..."
                                onChange={e => setData('thumbnail', e.target.value)} style={inputStyle}
                            />
                            {errors.thumbnail && <div style={errorStyle}>{errors.thumbnail}</div>}
                        </div>

                        <div style={{ display: 'flex', gap: '10px' }}>
                            <button type="submit" disabled={processing} style={{
                                background: 'linear-gradient(135deg, #e3000f, #cc0000)', color: '#fff',
                                border: 'none', padding: '10px 24px', borderRadius: '8px',
                                fontWeight: 600, fontSize: '14px', cursor: processing ? 'not-allowed' : 'pointer',
                                opacity: processing ? 0.7 : 1,
                            }}>
                                {processing ? 'Saving...' : (isEdit ? 'Update Course' : 'Create Course')}
                            </button>
                            <Link href={route('admin.courses.index')} style={{
                                background: '#f3f4f6', color: '#6b7280', padding: '10px 20px',
                                borderRadius: '8px', textDecoration: 'none', fontWeight: 500, fontSize: '14px',
                            }}>
                                Cancel
                            </Link>
                        </div>
                    </form>
                </div>
            </div>
        </AdminLayout>
    );
}
