import LmsLayout from '@/Layouts/LmsLayout';
import { Head } from '@inertiajs/react';

export default function LiveClassesIndex({ auth, classes }) {
    const allClasses = classes || [
        { id: 1, title: 'React Advanced Patterns', host: 'Prof. Rao', course: 'Full Stack Web Dev', time: 'Today, 3:00 PM', zoom_link: '#', status: 'live' },
        { id: 2, title: 'Neural Networks Deep Dive', host: 'Prof. Sharma', course: 'Data Science & ML', time: 'Today, 5:00 PM', zoom_link: '#', status: 'upcoming' },
        { id: 3, title: 'Design Systems with Figma', host: 'Prof. Nair', course: 'UI/UX Design', time: 'Tomorrow, 10:00 AM', zoom_link: '#', status: 'upcoming' },
    ];

    const liveNow = allClasses.filter(c => c.status === 'live');
    const upcoming = allClasses.filter(c => c.status === 'upcoming');

    const card = { background: '#fff', borderRadius: '8px', boxShadow: '0 1px 3px rgba(0,0,0,0.08)' };

    return (
        <LmsLayout title="Live Classes">
            <Head title="Live Classes" />

            {/* Live Now */}
            {liveNow.length > 0 && (
                <div style={{ marginBottom: '28px' }}>
                    <div style={{ display: 'flex', alignItems: 'center', gap: '8px', marginBottom: '14px' }}>
                        <span style={{ width: '9px', height: '9px', background: '#ef4444', borderRadius: '50%', display: 'inline-block' }}></span>
                        <h2 style={{ color: '#1f2937', fontSize: '16px', fontWeight: 700, margin: 0 }}>Live Now</h2>
                    </div>
                    <div className="row g-3">
                        {liveNow.map(cls => (
                            <div key={cls.id} className="col-12 col-md-6">
                                <div style={{ background: '#fff', borderRadius: '8px', border: '1px solid #fecaca', boxShadow: '0 1px 3px rgba(239,68,68,0.1)', padding: '20px' }}>
                                    <div style={{ display: 'flex', alignItems: 'center', gap: '8px', marginBottom: '10px' }}>
                                        <span style={{ padding: '3px 8px', borderRadius: '4px', background: '#ef4444', color: '#fff', fontSize: '11px', fontWeight: 700 }}>● LIVE</span>
                                    </div>
                                    <h3 style={{ color: '#1f2937', fontSize: '16px', fontWeight: 700, marginBottom: '6px' }}>{cls.title}</h3>
                                    <div style={{ color: '#6b7280', fontSize: '12px', marginBottom: '16px' }}>
                                        <i className="bi bi-person-circle me-1"></i>{cls.host} · {cls.course}
                                    </div>
                                    <a href={cls.zoom_link} target="_blank" rel="noopener noreferrer" style={{
                                        display: 'inline-flex', alignItems: 'center', gap: '6px', padding: '9px 20px',
                                        background: '#ef4444', color: '#fff', borderRadius: '6px', textDecoration: 'none', fontSize: '13px', fontWeight: 600,
                                    }}>
                                        <i className="bi bi-camera-video-fill"></i> Join Class Now
                                    </a>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            )}

            {/* Upcoming Schedule */}
            <div>
                <h2 style={{ color: '#1f2937', fontSize: '16px', fontWeight: 700, marginBottom: '14px' }}>Upcoming Schedule</h2>
                <div style={{ ...card, overflow: 'hidden' }}>
                    {upcoming.map((cls, i) => (
                        <div key={cls.id} style={{
                            display: 'flex', alignItems: 'center', gap: '14px', padding: '16px 20px',
                            borderBottom: i < upcoming.length - 1 ? '1px solid #f3f4f6' : 'none',
                            transition: 'background 0.1s',
                        }}
                            onMouseEnter={e => e.currentTarget.style.background = '#f9fafb'}
                            onMouseLeave={e => e.currentTarget.style.background = ''}
                        >
                            <div style={{ width: '44px', height: '44px', borderRadius: '8px', background: '#fef3c7', display: 'flex', alignItems: 'center', justifyContent: 'center', flexShrink: 0 }}>
                                <i className="bi bi-camera-video-fill" style={{ color: '#f59e0b', fontSize: '18px' }}></i>
                            </div>
                            <div style={{ flex: 1 }}>
                                <div style={{ color: '#1f2937', fontSize: '14px', fontWeight: 600 }}>{cls.title}</div>
                                <div style={{ color: '#6b7280', fontSize: '12px' }}>
                                    <i className="bi bi-person me-1"></i>{cls.host} · <i className="bi bi-collection-play me-1"></i>{cls.course}
                                </div>
                            </div>
                            <div style={{ textAlign: 'right', flexShrink: 0 }}>
                                <div style={{ color: '#6b7280', fontSize: '12px', marginBottom: '8px' }}>
                                    <i className="bi bi-clock me-1"></i>{cls.time}
                                </div>
                                <a href={cls.zoom_link} target="_blank" rel="noopener noreferrer" style={{
                                    padding: '6px 14px', background: '#eff6ff', border: '1px solid #bfdbfe',
                                    color: '#2563eb', borderRadius: '5px', textDecoration: 'none', fontSize: '12px', fontWeight: 600,
                                }}>
                                    Add to Calendar
                                </a>
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </LmsLayout>
    );
}
