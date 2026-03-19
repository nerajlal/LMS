import AdminLayout from '@/Layouts/AdminLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function AdminMaterialsCreate({ auth, courses }) {
    const { data, setData, post, processing, errors } = useForm({
        course_id: '',
        title: '',
        file_path: '',
        file_type: 'PDF',
        file_size: '',
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route('admin.study-materials.store'));
    };

    return (
        <AdminLayout user={auth.user}>
            <Head title="Add Course Material" />

            <div className="d-flex align-items-center justify-content-between mb-4">
                <h1 className="h3 mb-0 text-gray-800">Add New Resource</h1>
                <Link href={route('admin.study-materials.index')} className="btn btn-secondary btn-sm shadow-sm">
                    Back to List
                </Link>
            </div>

            <div className="card shadow mb-4">
                <div className="card-body">
                    <form onSubmit={handleSubmit}>
                        <div className="mb-3">
                            <label className="form-label">Select Course</label>
                            <select 
                                className={`form-select ${errors.course_id ? 'is-invalid' : ''}`}
                                value={data.course_id}
                                onChange={e => setData('course_id', e.target.value)}
                            >
                                <option value="">Choose a course...</option>
                                {courses.map(c => <option key={c.id} value={c.id}>{c.title}</option>)}
                            </select>
                            {errors.course_id && <div className="invalid-feedback">{errors.course_id}</div>}
                        </div>

                        <div className="mb-3">
                            <label className="form-label">Material Title</label>
                            <input 
                                type="text" 
                                className={`form-control ${errors.title ? 'is-invalid' : ''}`}
                                value={data.title}
                                onChange={e => setData('title', e.target.value)}
                                placeholder="e.g., React Lifecycle Methods Guide"
                            />
                            {errors.title && <div className="invalid-feedback">{errors.title}</div>}
                        </div>

                        <div className="mb-3">
                            <label className="form-label">Mock File Path (Relative to /storage)</label>
                            <input 
                                type="text" 
                                className={`form-control ${errors.file_path ? 'is-invalid' : ''}`}
                                value={data.file_path}
                                onChange={e => setData('file_path', e.target.value)}
                                placeholder="e.g., /materials/hooks-guide.pdf"
                            />
                            {errors.file_path && <div className="invalid-feedback">{errors.file_path}</div>}
                        </div>

                        <div className="row">
                            <div className="col-md-6 mb-3">
                                <label className="form-label">File Type</label>
                                <select 
                                    className="form-select"
                                    value={data.file_type}
                                    onChange={e => setData('file_type', e.target.value)}
                                >
                                    <option value="PDF">PDF Document</option>
                                    <option value="DOCX">Word Document</option>
                                    <option value="ZIP">ZIP Archive</option>
                                    <option value="PPTX">PowerPoint</option>
                                </select>
                            </div>
                            <div className="col-md-6 mb-3">
                                <label className="form-label">Display Size (e.g., 2.5 MB)</label>
                                <input 
                                    type="text" 
                                    className={`form-control ${errors.file_size ? 'is-invalid' : ''}`}
                                    value={data.file_size}
                                    onChange={e => setData('file_size', e.target.value)}
                                    placeholder="e.g., 2.5 MB"
                                />
                                {errors.file_size && <div className="invalid-feedback">{errors.file_size}</div>}
                            </div>
                        </div>

                        <button type="submit" className="btn btn-primary" disabled={processing}>
                            {processing ? 'Adding...' : 'Add Material'}
                        </button>
                    </form>
                </div>
            </div>
        </AdminLayout>
    );
}
