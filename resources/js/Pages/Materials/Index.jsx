import LmsLayout from '@/Layouts/LmsLayout';
import { Head } from '@inertiajs/react';

const cardStyle = {
    background: '#fff',
    borderRadius: '16px',
    boxShadow: '0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03)',
    padding: '24px',
    border: '1px solid #f1f5f9',
};

export default function MaterialsIndex({ auth, materials }) {
    const allMaterials = materials || [
        { id: 1, title: 'Introduction to React.pdf', type: 'PDF', size: '2.4 MB', course: 'Full Stack Web Development' },
        { id: 2, title: 'Data Cleaning Handbook.docx', type: 'DOCX', size: '1.1 MB', course: 'Data Science & ML' },
        { id: 3, title: 'UI Design Assets.zip', type: 'ZIP', size: '15.8 MB', course: 'UI/UX Design' },
    ];

    const getIcon = (type) => {
        switch(type) {
            case 'PDF': return { icon: 'bi-file-earmark-pdf', color: '#ef4444', bg: '#fef2f2' };
            case 'ZIP': return { icon: 'bi-file-earmark-zip', color: '#8b5cf6', bg: '#f5f3ff' };
            default:    return { icon: 'bi-file-earmark-text', color: '#2563eb', bg: '#eff6ff' };
        }
    };

    return (
        <LmsLayout title="Study Materials">
            <Head title="Course Materials - EduLMS" />

            <div style={{ marginBottom: '32px' }}>
                <h2 style={{ fontSize: '24px', fontWeight: 800, color: '#1e293b', marginBottom: '8px' }}>Course Resources</h2>
                <p style={{ fontSize: '15px', color: '#64748b' }}>Download PDFs, guides, and assets for your courses.</p>
            </div>

            <div className="row g-4">
                {allMaterials.map(item => {
                    const style = getIcon(item.type);
                    return (
                        <div key={item.id} className="col-12 col-md-6 col-xl-4">
                            <div style={cardStyle}>
                                <div style={{ display: 'flex', gap: '16px', alignItems: 'flex-start' }}>
                                    <div style={{ width: '48px', height: '48px', borderRadius: '12px', background: style.bg, color: style.color, display: 'flex', alignItems: 'center', justifyContent: 'center', fontSize: '20px', flexShrink: 0 }}>
                                        <i className={`bi ${style.icon}`}></i>
                                    </div>
                                    <div style={{ flex: 1, overflow: 'hidden' }}>
                                        <div style={{ fontSize: '15px', fontWeight: 700, color: '#1e293b', marginBottom: '4px', whiteSpace: 'nowrap', overflow: 'hidden', textOverflow: 'ellipsis' }}>{item.title}</div>
                                        <div style={{ fontSize: '12px', color: '#64748b', marginBottom: '12px' }}>{item.course}</div>
                                        <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between' }}>
                                            <span style={{ fontSize: '11px', fontWeight: 700, color: '#94a3b8' }}>{item.type} • {item.size}</span>
                                            <button style={{ padding: '6px 14px', background: '#f1f5f9', border: 'none', borderRadius: '8px', color: '#1e293b', fontSize: '12px', fontWeight: 700, cursor: 'pointer' }}>
                                                <i className="bi bi-download me-1"></i> Download
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    );
                })}
            </div>
        </LmsLayout>
    );
}
