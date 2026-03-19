import AdminLayout from '@/Layouts/AdminLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function AdminLiveClassesCreate({ auth, courses }) {
    const { data, setData, post, processing, errors } = useForm({
        course_id: '',
        title: '',
        instructor_name: '',
        start_time: '',
        duration: '',
        zoom_link: '',
        status: 'upcoming',
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route('admin.live-classes.store'));
    };

    return (
        <AdminLayout user={auth.user}>
            <Head title="Schedule Live Class" />

            <div className="d-flex align-items-center justify-content-between mb-4">
                <h1 className="h3 mb-0 text-gray-800">Schedule New Session</h1>
                <Link href={route('admin.live-classes.index')} className="btn btn-secondary btn-sm shadow-sm">
                    Back to List
                </Link>
            </div>

            <div className="card shadow mb-4">
                <div className="card-body">
                    <form onSubmit={handleSubmit}>
                        <div className="row">
                            <div className="col-md-6 mb-3">
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
                            <div className="col-md-6 mb-3">
                                <label className="form-label">Instructor Name</label>
                                <input 
                                    type="text" 
                                    className={`form-control ${errors.instructor_name ? 'is-invalid' : ''}`}
                                    value={data.instructor_name}
                                    onChange={e => setData('instructor_name', e.target.value)}
                                />
                                {errors.instructor_name && <div className="invalid-feedback">{errors.instructor_name}</div>}
                            </div>
                        </div>

                        <div className="mb-3">
                            <label className="form-label">Session Title</label>
                            <input 
                                type="text" 
                                className={`form-control ${errors.title ? 'is-invalid' : ''}`}
                                value={data.title}
                                onChange={e => setData('title', e.target.value)}
                                placeholder="e.g., Q&A Session on React Basics"
                            />
                            {errors.title && <div className="invalid-feedback">{errors.title}</div>}
                        </div>

                        <div className="row">
                            <div className="col-md-6 mb-3">
                                <label className="form-label">Start Date & Time</label>
                                <input 
                                    type="datetime-local" 
                                    className={`form-control ${errors.start_time ? 'is-invalid' : ''}`}
                                    value={data.start_time}
                                    onChange={e => setData('start_time', e.target.value)}
                                />
                                {errors.start_time && <div className="invalid-feedback">{errors.start_time}</div>}
                            </div>
                            <div className="col-md-6 mb-3">
                                <label className="form-label">Duration (e.g., 60 mins)</label>
                                <input 
                                    type="text" 
                                    className={`form-control ${errors.duration ? 'is-invalid' : ''}`}
                                    value={data.duration}
                                    onChange={e => setData('duration', e.target.value)}
                                />
                                {errors.duration && <div className="invalid-feedback">{errors.duration}</div>}
                            </div>
                        </div>

                        <div className="mb-3">
                            <label className="form-label">Zoom/Meeting Link</label>
                            <input 
                                type="url" 
                                className={`form-control ${errors.zoom_link ? 'is-invalid' : ''}`}
                                value={data.zoom_link}
                                onChange={e => setData('zoom_link', e.target.value)}
                                placeholder="https://zoom.us/j/..."
                            />
                            {errors.zoom_link && <div className="invalid-feedback">{errors.zoom_link}</div>}
                        </div>

                        <div className="mb-4">
                            <label className="form-label">Initial Status</label>
                            <select 
                                className="form-select"
                                value={data.status}
                                onChange={e => setData('status', e.target.value)}
                            >
                                <option value="upcoming">Upcoming</option>
                                <option value="live">Live Now</option>
                            </select>
                        </div>

                        <button type="submit" className="btn btn-primary" disabled={processing}>
                            {processing ? 'Scheduling...' : 'Schedule Session'}
                        </button>
                    </form>
                </div>
            </div>
        </AdminLayout>
    );
}
