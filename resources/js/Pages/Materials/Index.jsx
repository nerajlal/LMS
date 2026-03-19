import LmsLayout from '@/Layouts/LmsLayout';
import { Head } from '@inertiajs/react';
import { useState } from 'react';

export default function MaterialsIndex({ auth, materials }) {
    const [search, setSearch] = useState('');
    const allMaterials = materials || [
        { id: 1, name: 'Week 1 - HTML & CSS Notes', course: 'Full Stack Web Dev', type: 'pdf', size: '2.4 MB', date: '2026-03-01' },
        { id: 2, name: 'Week 2 - JavaScript Basics', course: 'Full Stack Web Dev', type: 'pdf', size: '3.1 MB', date: '2026-03-08' },
        { id: 3, name: 'Pandas & NumPy Cheatsheet', course: 'Data Science & ML', type: 'pdf', size: '1.8 MB', date: '2026-03-05' },
        { id: 4, name: 'UX Research Methods', course: 'UI/UX Design', type: 'pdf', size: '4.2 MB', date: '2026-03-10' },
        { id: 5, name: 'React Hooks Reference Guide', course: 'Full Stack Web Dev', type: 'pdf', size: '1.5 MB', date: '2026-03-15' },
        { id: 6, name: 'ML Assignment - Week 3', course: 'Data Science & ML', type: 'doc', size: '880 KB', date: '2026-03-18' },
    ];

    const filtered = allMaterials.filter(m =>
        m.name.toLowerCase().includes(search.toLowerCase()) ||
        m.course.toLowerCase().includes(search.toLowerCase())
    );

    const typeIcon = { pdf: 'bi-file-earmark-pdf-fill', doc: 'bi-file-earmark-word-fill', zip: 'bi-file-earmark-zip-fill' };
    const typeColor = { pdf: '#ef4444', doc: '#3b82f6', zip: '#f59e0b' };

    return (
        <LmsLayout>
            <Head title="Study Materials" />
            <div className="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h1 style={{ color: '#fff', fontSize: '24px', fontWeight: 700, margin: 0 }}>Study Materials</h1>
                    <p style={{ color: 'rgba(255,255,255,0.5)', fontSize: '14px', margin: '4px 0 0 0' }}>Download course materials and resources</p>
                </div>
            </div>

            {/* Search */}
            <div style={{ position: 'relative', maxWidth: '400px', marginBottom: '24px' }}>
                <i className="bi bi-search" style={{ position: 'absolute', left: '12px', top: '50%', transform: 'translateY(-50%)', color: 'rgba(255,255,255,0.4)', fontSize: '14px' }}></i>
                <input
                    type="text"
                    placeholder="Search materials..."
                    value={search}
                    onChange={e => setSearch(e.target.value)}
                    style={{ width: '100%', background: 'rgba(255,255,255,0.07)', border: '1px solid rgba(255,255,255,0.1)', borderRadius: '10px', color: '#fff', padding: '10px 12px 10px 36px', fontSize: '14px', outline: 'none' }}
                />
            </div>

            {/* Materials Grid */}
            <div className="row g-3">
                {filtered.map(mat => (
                    <div key={mat.id} className="col-12 col-md-6 col-lg-4">
                        <div style={{
                            display: 'flex', flexDirection: 'column', gap: '12px', padding: '20px',
                            background: 'rgba(255,255,255,0.04)', border: '1px solid rgba(255,255,255,0.08)',
                            borderRadius: '14px', transition: 'transform 0.2s, box-shadow 0.2s',
                        }}
                            onMouseEnter={e => { e.currentTarget.style.transform = 'translateY(-4px)'; e.currentTarget.style.boxShadow = '0 12px 40px rgba(0,0,0,0.3)'; }}
                            onMouseLeave={e => { e.currentTarget.style.transform = ''; e.currentTarget.style.boxShadow = ''; }}
                        >
                            <div className="d-flex align-items-center gap-3">
                                <div style={{ width: '44px', height: '44px', borderRadius: '10px', background: `${typeColor[mat.type] || '#7c3aed'}22`, display: 'flex', alignItems: 'center', justifyContent: 'center', flexShrink: 0 }}>
                                    <i className={`bi ${typeIcon[mat.type] || 'bi-file-earmark'}`} style={{ color: typeColor[mat.type] || '#7c3aed', fontSize: '22px' }}></i>
                                </div>
                                <div>
                                    <div style={{ color: '#fff', fontSize: '14px', fontWeight: 600, lineHeight: 1.3 }}>{mat.name}</div>
                                    <div style={{ color: 'rgba(255,255,255,0.45)', fontSize: '12px' }}>{mat.course}</div>
                                </div>
                            </div>
                            <div className="d-flex justify-content-between align-items-center pt-1" style={{ borderTop: '1px solid rgba(255,255,255,0.06)' }}>
                                <span style={{ color: 'rgba(255,255,255,0.4)', fontSize: '12px' }}>
                                    <i className="bi bi-hdd me-1"></i>{mat.size} · {mat.date}
                                </span>
                                <a href="#" style={{
                                    padding: '6px 14px', background: 'rgba(124,58,237,0.15)', border: '1px solid rgba(124,58,237,0.3)',
                                    color: '#7c3aed', borderRadius: '8px', textDecoration: 'none', fontSize: '12px', fontWeight: 600,
                                }}>
                                    <i className="bi bi-download me-1"></i> Download
                                </a>
                            </div>
                        </div>
                    </div>
                ))}
                {filtered.length === 0 && (
                    <div className="col-12 text-center py-5" style={{ color: 'rgba(255,255,255,0.4)' }}>
                        <i className="bi bi-folder-x" style={{ fontSize: '48px', display: 'block', marginBottom: '12px' }}></i>
                        No materials found.
                    </div>
                )}
            </div>
        </LmsLayout>
    );
}
