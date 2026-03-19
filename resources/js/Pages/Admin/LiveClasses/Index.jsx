import AdminLayout from '@/Layouts/AdminLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function AdminLiveClassesIndex({ auth, liveClasses }) {
    const { delete: destroy } = useForm();

    const handleDelete = (id) => {
        if (confirm('Are you sure you want to remove this live session?')) {
            destroy(route('admin.live-classes.destroy', id));
        }
    };

    return (
        <AdminLayout user={auth.user}>
            <Head title="Manage Live Classes" />

            <div className="d-flex align-items-center justify-content-between mb-4">
                <h1 className="h3 mb-0 text-gray-800">Live Class Schedule</h1>
                <Link href={route('admin.live-classes.create')} className="btn btn-primary btn-sm shadow-sm">
                    <i className="bi bi-plus-lg me-1"></i> Schedule New Session
                </Link>
            </div>

            <div className="card shadow mb-4">
                <div className="card-body">
                    <div className="table-responsive">
                        <table className="table table-bordered" width="100%" cellSpacing="0">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Course</th>
                                    <th>Instructor</th>
                                    <th>Start Time</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                {liveClasses.data.map((cls) => (
                                    <tr key={cls.id}>
                                        <td>{cls.title}</td>
                                        <td>{cls.course?.title}</td>
                                        <td>{cls.instructor_name}</td>
                                        <td>{new Date(cls.start_time).toLocaleString()}</td>
                                        <td>
                                            <span className={`badge bg-${cls.status === 'upcoming' ? 'info' : (cls.status === 'live' ? 'success' : 'secondary')}`}>
                                                {cls.status}
                                            </span>
                                        </td>
                                        <td>
                                            <button onClick={() => handleDelete(cls.id)} className="btn btn-danger btn-sm">
                                                <i className="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                ))}
                                {liveClasses.data.length === 0 && (
                                    <tr>
                                        <td colSpan="6" className="text-center py-4">No live classes scheduled.</td>
                                    </tr>
                                )}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </AdminLayout>
    );
}
