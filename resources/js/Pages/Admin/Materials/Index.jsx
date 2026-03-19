import AdminLayout from '@/Layouts/AdminLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function AdminMaterialsIndex({ auth, materials }) {
    const { delete: destroy } = useForm();

    const handleDelete = (id) => {
        if (confirm('Are you sure you want to delete this resource?')) {
            destroy(route('admin.study-materials.destroy', id));
        }
    };

    return (
        <AdminLayout user={auth.user}>
            <Head title="Manage Course Resources" />

            <div className="d-flex align-items-center justify-content-between mb-4">
                <h1 className="h3 mb-0 text-gray-800">Course Materials</h1>
                <Link href={route('admin.study-materials.create')} className="btn btn-primary btn-sm shadow-sm">
                    <i className="bi bi-plus-lg me-1"></i> Add New Material
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
                                    <th>Type</th>
                                    <th>Size</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                {materials.data.map((item) => (
                                    <tr key={item.id}>
                                        <td>{item.title}</td>
                                        <td>{item.course?.title}</td>
                                        <td><span className="badge bg-secondary">{item.file_type}</span></td>
                                        <td>{item.file_size}</td>
                                        <td>
                                            <button onClick={() => handleDelete(item.id)} className="btn btn-danger btn-sm">
                                                <i className="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                ))}
                                {materials.data.length === 0 && (
                                    <tr>
                                        <td colSpan="5" className="text-center py-4">No materials uploaded.</td>
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
