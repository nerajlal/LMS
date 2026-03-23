import AdminLayout from '@/Layouts/AdminLayout';
import { Head } from '@inertiajs/react';

export default function AdminStudentsIndex({ students }) {
    return (
        <AdminLayout title="Students">
            <Head title="Admin — Students" />

            <div style={{ marginBottom: '20px' }}>
                <h1 style={{ margin: 0, fontSize: '20px', fontWeight: 700, color: '#1f2937' }}>All Students</h1>
                <p style={{ margin: '2px 0 0', color: '#6b7280', fontSize: '14px' }}>{students?.total ?? 0} registered students</p>
            </div>

            <div style={{ background: '#fff', borderRadius: '12px', boxShadow: '0 1px 4px rgba(0,0,0,0.08)', overflow: 'hidden' }}>
                <div style={{ overflowX: 'auto' }}>
                    <table style={{ width: '100%', borderCollapse: 'collapse', fontSize: '14px' }}>
                        <thead>
                            <tr style={{ background: '#f9fafb' }}>
                                {['#', 'Name', 'Email', 'Admissions', 'Enrollments', 'Joined'].map(h => (
                                    <th key={h} style={{ padding: '12px 16px', textAlign: 'left', fontWeight: 600, color: '#6b7280', fontSize: '12px', textTransform: 'uppercase', letterSpacing: '0.04em', whiteSpace: 'nowrap' }}>{h}</th>
                                ))}
                            </tr>
                        </thead>
                        <tbody>
                            {(students?.data || []).length === 0 ? (
                                <tr><td colSpan="6" style={{ padding: '32px', textAlign: 'center', color: '#9ca3af' }}>
                                    No students registered yet. Seed demo data to see students.
                                </td></tr>
                            ) : students.data.map((student, i) => (
                                <tr key={student.id} style={{ borderTop: '1px solid #f3f4f6' }}
                                    onMouseEnter={e => e.currentTarget.style.background = '#fafafa'}
                                    onMouseLeave={e => e.currentTarget.style.background = 'transparent'}
                                >
                                    <td style={{ padding: '12px 16px', color: '#9ca3af', fontSize: '13px' }}>{i + 1}</td>
                                    <td style={{ padding: '12px 16px' }}>
                                        <div style={{ display: 'flex', alignItems: 'center', gap: '10px' }}>
                                            <div style={{
                                                width: '34px', height: '34px', borderRadius: '50%', flexShrink: 0,
                                                background: 'linear-gradient(135deg, #cc0000, #e3000f)',
                                                display: 'flex', alignItems: 'center', justifyContent: 'center',
                                                color: '#fff', fontWeight: 700, fontSize: '13px',
                                            }}>
                                                {student.name?.charAt(0).toUpperCase()}
                                            </div>
                                            <span style={{ fontWeight: 600, color: '#1f2937' }}>{student.name}</span>
                                        </div>
                                    </td>
                                    <td style={{ padding: '12px 16px', color: '#6b7280' }}>{student.email}</td>
                                    <td style={{ padding: '12px 16px', color: '#6b7280' }}>
                                        <span style={{ background: '#eff6ff', color: '#cc0000', borderRadius: '20px', padding: '2px 10px', fontSize: '12px', fontWeight: 600 }}>
                                            {student.admissions_count ?? 0}
                                        </span>
                                    </td>
                                    <td style={{ padding: '12px 16px', color: '#6b7280' }}>
                                        <span style={{ background: '#f0fdf4', color: '#10b981', borderRadius: '20px', padding: '2px 10px', fontSize: '12px', fontWeight: 600 }}>
                                            {student.enrollments_count ?? 0}
                                        </span>
                                    </td>
                                    <td style={{ padding: '12px 16px', color: '#9ca3af', fontSize: '13px' }}>
                                        {new Date(student.created_at).toLocaleDateString()}
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            </div>
        </AdminLayout>
    );
}
