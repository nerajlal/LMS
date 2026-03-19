import LmsLayout from '@/Layouts/LmsLayout';
import { Head } from '@inertiajs/react';

export default function LiveClassesIndex({ auth, classes }) {
    const allClasses = classes || [
        { id: 1, title: 'React Advanced Patterns', host: 'Prof. Rao', course: 'Full Stack Web Dev', time: 'Today, 3:00 PM', zoom_link: '#', status: 'live' },
        { id: 2, title: 'Neural Networks Deep Dive', host: 'Prof. Sharma', course: 'Data Science & ML', time: 'Today, 5:00 PM', zoom_link: '#', status: 'upcoming' },
        { id: 3, title: 'Design Systems with Figma', host: 'Prof. Nair', course: 'UI/UX Design', time: 'Tomorrow, 10:00 AM', zoom_link: '#', status: 'upcoming' },
        { id: 4, title: 'Node.js REST APIs', host: 'Prof. Rao', course: 'Full Stack Web Dev', time: 'Mar 22, 2:00 PM', zoom_link: '#', status: 'upcoming' },
    ];

    const liveNow = allClasses.filter(c => c.status === 'live');
    const upcoming = allClasses.filter(c => c.status === 'upcoming');

    return (
        <LmsLayout>
            <Head title="Live Classes" />
            <div className="mb-4">
                <h1 style={{ color: '#fff', fontSize: '24px', fontWeight: 700, margin: 0 }}>Live Classes</h1>
                <p style={{ color: 'rgba(255,255,255,0.5)', fontSize: '14px', margin: '4px 0 0 0' }}>Join live sessions and never miss a class</p>
            </div>

            {/* Live Now */}
            {liveNow.length > 0 && (
                <div className="mb-4">
                    <div className="d-flex align-items-center gap-2 mb-3">
                        <span style={{ width: '10px', height: '10px', background: '#ef4444', borderRadius: '50%', animation: 'pulse 1.5s infinite', flexShrink: 0 }}></span>
                        <h2 style={{ color: '#fff', fontSize: '18px', fontWeight: 700, margin: 0 }}>Live Now</h2>
                    </div>
                    <div className="row g-3">
                        {liveNow.map(cls => (
                            <div key={cls.id} className="col-12 col-md-6">
                                <div style={{ background: 'linear-gradient(135deg, rgba(239,68,68,0.15), rgba(239,68,68,0.05))', border: '1px solid rgba(239,68,68,0.3)', borderRadius: '16px', padding: '24px' }}>
                                    <div className="d-flex align-items-center gap-2 mb-2">
                                        <span style={{ padding: '3px 10px', borderRadius: '100px', background: '#ef4444', color: '#fff', fontSize: '11px', fontWeight: 700 }}>● LIVE</span>
                                    </div>
                                    <h3 style={{ color: '#fff', fontSize: '18px', fontWeight: 700, marginBottom: '6px' }}>{cls.title}</h3>
                                    <div style={{ color: 'rgba(255,255,255,0.5)', fontSize: '13px', marginBottom: '16px' }}>
                                        <i className="bi bi-person-circle me-1"></i> {cls.host} · {cls.course}
                                    </div>
                                    <a href={cls.zoom_link} target="_blank" rel="noopener noreferrer" style={{
                                        display: 'inline-flex', alignItems: 'center', gap: '8px', padding: '11px 24px',
                                        background: '#ef4444', color: '#fff', borderRadius: '10px', textDecoration: 'none',
                                        fontSize: '14px', fontWeight: 700, transition: 'opacity 0.2s',
                                    }}
                                        onMouseEnter={e => e.currentTarget.style.opacity = '0.85'}
                                        onMouseLeave={e => e.currentTarget.style.opacity = '1'}
                                    >
                                        <i className="bi bi-camera-video-fill"></i> Join Class Now
                                    </a>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            )}

            {/* Upcoming */}
            <div>
                <h2 style={{ color: '#fff', fontSize: '18px', fontWeight: 700, marginBottom: '16px' }}>Upcoming Classes</h2>
                <div className="d-flex flex-column gap-3">
                    {upcoming.map(cls => (
                        <div key={cls.id} style={{
                            display: 'flex', alignItems: 'center', gap: '16px',
                            background: 'rgba(255,255,255,0.04)', border: '1px solid rgba(255,255,255,0.08)',
                            borderRadius: '14px', padding: '20px',
                        }}>
                            <div style={{ width: '52px', height: '52px', borderRadius: '12px', background: '#f59e0b22', display: 'flex', alignItems: 'center', justifyContent: 'center', flexShrink: 0 }}>
                                <i className="bi bi-camera-video-fill" style={{ color: '#f59e0b', fontSize: '22px' }}></i>
                            </div>
                            <div style={{ flex: 1 }}>
                                <div style={{ color: '#fff', fontSize: '15px', fontWeight: 600 }}>{cls.title}</div>
                                <div style={{ color: 'rgba(255,255,255,0.45)', fontSize: '13px' }}>
                                    <i className="bi bi-person-circle me-1"></i>{cls.host} · <i className="bi bi-collection-play me-1 ms-1"></i>{cls.course}
                                </div>
                            </div>
                            <div style={{ textAlign: 'right', flexShrink: 0 }}>
                                <div style={{ color: 'rgba(255,255,255,0.6)', fontSize: '13px', marginBottom: '8px' }}>
                                    <i className="bi bi-clock me-1"></i>{cls.time}
                                </div>
                                <a href={cls.zoom_link} target="_blank" rel="noopener noreferrer" style={{
                                    padding: '7px 16px', background: 'rgba(124,58,237,0.15)', border: '1px solid rgba(124,58,237,0.3)',
                                    color: '#7c3aed', borderRadius: '8px', textDecoration: 'none', fontSize: '13px', fontWeight: 600,
                                }}>
                                    <i className="bi bi-calendar-event me-1"></i> Add to Calendar
                                </a>
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </LmsLayout>
    );
}
