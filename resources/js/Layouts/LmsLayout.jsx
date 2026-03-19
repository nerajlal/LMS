import { useState, useEffect } from 'react';
import { Link, usePage } from '@inertiajs/react';

const NAV_ITEMS = [
    { label: 'Learning Dashboard', icon: 'bi-grid-1x2',          href: 'dashboard' },
    { label: 'Browse Courses',     icon: 'bi-collection-play',    href: 'courses.index' },
    { label: 'My Enrollment',      icon: 'bi-journal-check',      href: 'enrollments.index' },
    { label: 'Live Classes',       icon: 'bi-camera-video',       href: 'live-classes.index' },
    { label: 'Study Materials',    icon: 'bi-file-earmark-text',  href: 'materials.index' },
    { label: 'Payments & Fees',    icon: 'bi-credit-card',        href: 'fees.index' },
    { label: 'Register Course',    icon: 'bi-person-plus',        href: 'admissions.create' },
];

export default function LmsLayout({ children, title }) {
    const { auth, flash } = usePage().props;
    const user = auth?.user;
    const [sidebarOpen, setSidebarOpen] = useState(true);
    const [showFlash, setShowFlash] = useState(false);

    useEffect(() => {
        if (flash?.success || flash?.error) {
            setShowFlash(true);
            const timer = setTimeout(() => setShowFlash(false), 5000);
            return () => clearTimeout(timer);
        }
    }, [flash]);

    const currentPath = typeof window !== 'undefined' ? window.location.pathname.split('/').filter(Boolean) : [];

    return (
        <div style={{ display: 'flex', minHeight: '100vh', background: '#f8fafc', fontFamily: "'Inter', sans-serif" }}>

            {/* Flash Messages */}
            {showFlash && (flash?.success || flash?.error) && (
                <div style={{
                    position: 'fixed', top: '88px', right: '32px', zIndex: 2000,
                    minWidth: '300px', animation: 'slideIn 0.3s ease-out',
                }}>
                    <div style={{
                        padding: '16px 20px', borderRadius: '12px', background: flash.success ? '#10b981' : '#ef4444',
                        color: '#fff', boxShadow: '0 10px 15px -3px rgba(0,0,0,0.1)', display: 'flex', alignItems: 'center', gap: '12px'
                    }}>
                        <i className={`bi ${flash.success ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill'}`} style={{ fontSize: '20px' }}></i>
                        <div style={{ fontWeight: 600, fontSize: '14px' }}>{flash.success || flash.error}</div>
                        <button onClick={() => setShowFlash(false)} style={{ marginLeft: 'auto', background: 'transparent', border: 'none', color: '#fff', opacity: 0.7, cursor: 'pointer' }}>
                            <i className="bi bi-x-lg"></i>
                        </button>
                    </div>
                </div>
            )}

            <style>{`
                @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
            `}</style>

            {/* ── SIDEBAR ── */}
            <aside style={{
                width: sidebarOpen ? '260px' : '72px',
                minHeight: '100vh',
                background: '#ffffff',
                borderRight: '1px solid #e2e8f0',
                display: 'flex',
                flexDirection: 'column',
                position: 'fixed',
                top: 0, left: 0,
                zIndex: 1040,
                transition: 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)',
                overflowX: 'hidden',
                boxShadow: '4px 0 24px rgba(0,0,0,0.02)',
            }}>
                <div style={{ height: '72px', display: 'flex', alignItems: 'center', padding: '0 20px', borderBottom: '1px solid #f1f5f9', gap: '12px', flexShrink: 0 }}>
                    <div style={{ width: '40px', height: '40px', borderRadius: '10px', background: 'linear-gradient(135deg, #2563eb, #1d4ed8)', display: 'flex', alignItems: 'center', justifyContent: 'center', flexShrink: 0, boxShadow: '0 4px 12px rgba(37, 99, 235, 0.2)' }}>
                        <i className="bi bi-mortarboard-fill" style={{ color: '#fff', fontSize: '18px' }}></i>
                    </div>
                    {sidebarOpen && (
                        <div>
                            <div style={{ fontWeight: 800, fontSize: '18px', color: '#1e293b', whiteSpace: 'nowrap', letterSpacing: '-0.5px' }}>EduLMS</div>
                            <div style={{ fontSize: '11px', color: '#64748b', fontWeight: 600, letterSpacing: '0.5px', textTransform: 'uppercase' }}>Portal</div>
                        </div>
                    )}
                </div>

                <nav style={{ flex: 1, padding: '20px 12px', overflowY: 'auto' }}>
                    {NAV_ITEMS.map(item => {
                        const href = `/${item.href.replace('.', '/')}`;
                        const active = window.location.pathname === href || (item.href === 'dashboard' && window.location.pathname === '/dashboard');
                        return (
                            <Link key={item.label} href={route(item.href)} style={{
                                display: 'flex', alignItems: 'center', gap: '12px', padding: '12px 14px', borderRadius: '10px', marginBottom: '4px',
                                color: active ? '#2563eb' : '#475569', background: active ? '#eff6ff' : 'transparent',
                                textDecoration: 'none', fontWeight: active ? 700 : 500, fontSize: '14px', whiteSpace: 'nowrap', transition: 'all 0.2s',
                            }}>
                                <i className={`bi ${item.icon}`} style={{ fontSize: '18px', width: '24px', textAlign: 'center', flexShrink: 0 }}></i>
                                {sidebarOpen && <span>{item.label}</span>}
                            </Link>
                        );
                    })}
                </nav>

                {user?.is_admin && sidebarOpen && (
                    <div style={{ padding: '20px 12px', borderTop: '1px solid #f1f5f9' }}>
                        <Link href={route('admin.dashboard')} style={{ display: 'flex', alignItems: 'center', gap: '12px', padding: '12px 14px', borderRadius: '10px', color: '#7c3aed', background: '#f5f3ff', textDecoration: 'none', fontWeight: 700, fontSize: '14px' }}>
                            <i className="bi bi-shield-check" style={{ fontSize: '18px' }}></i>
                            <span>Admin Panel</span>
                        </Link>
                    </div>
                )}

                {sidebarOpen && user && (
                    <div style={{ padding: '20px 16px', borderTop: '1px solid #f1f5f9', display: 'flex', alignItems: 'center', gap: '12px', background: '#f8fafc' }}>
                        <div style={{ width: '40px', height: '40px', borderRadius: '12px', flexShrink: 0, background: 'linear-gradient(135deg, #3b82f6, #2563eb)', display: 'flex', alignItems: 'center', justifyContent: 'center', color: '#fff', fontWeight: 800 }}>
                            {user.name?.charAt(0).toUpperCase()}
                        </div>
                        <div style={{ overflow: 'hidden' }}>
                            <div style={{ fontSize: '13px', fontWeight: 700, color: '#1e293b', whiteSpace: 'nowrap', overflow: 'hidden', textOverflow: 'ellipsis' }}>{user.name}</div>
                            <div style={{ fontSize: '11px', color: '#64748b' }}>{user.is_admin ? 'Admin' : 'Student'}</div>
                        </div>
                    </div>
                )}
            </aside>

            {/* ── MAIN CONTENT ── */}
            <div style={{ marginLeft: sidebarOpen ? '260px' : '72px', flex: 1, display: 'flex', flexDirection: 'column', transition: 'margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1)', minHeight: '100vh' }}>
                <header style={{
                    background: 'linear-gradient(to right, #2563eb, #1d4ed8)', height: '72px', display: 'flex', alignItems: 'center',
                    justifyContent: 'space-between', padding: '0 32px', position: 'sticky', top: 0, zIndex: 1030, boxShadow: '0 4px 20px rgba(37,99,235,0.15)',
                }}>
                    <div style={{ display: 'flex', alignItems: 'center', gap: '20px' }}>
                        <button onClick={() => setSidebarOpen(!sidebarOpen)} style={{ background: 'rgba(255,255,255,0.12)', border: 'none', borderRadius: '10px', color: '#fff', fontSize: '20px', cursor: 'pointer', padding: '8px 10px', display: 'flex' }}><i className="bi bi-list"></i></button>
                        <div>
                            {title && <h1 style={{ color: '#fff', fontSize: '18px', fontWeight: 700, margin: 0 }}>{title}</h1>}
                            <div style={{ display: 'flex', alignItems: 'center', gap: '6px', marginTop: '2px' }}>
                                <Link href={route('dashboard')} style={{ fontSize: '11px', color: 'rgba(255,255,255,0.7)', textDecoration: 'none' }}>EduLMS</Link>
                                {currentPath.map((segment, i) => (
                                    <span key={i} style={{ display: 'flex', alignItems: 'center', gap: '6px' }}>
                                        <i className="bi bi-chevron-right" style={{ fontSize: '8px', color: 'rgba(255,255,255,0.4)' }}></i>
                                        <span style={{ fontSize: '11px', color: i === currentPath.length - 1 ? '#fff' : 'rgba(255,255,255,0.7)', textTransform: 'capitalize' }}>{segment.replace(/-/g, ' ')}</span>
                                    </span>
                                ))}
                            </div>
                        </div>
                    </div>

                    <div style={{ display: 'flex', alignItems: 'center', gap: '16px' }}>
                        <Link href={route('logout')} method="post" as="button" style={{ background: 'rgba(255,255,255,0.15)', border: '1px solid rgba(255,255,255,0.2)', borderRadius: '10px', color: '#fff', padding: '8px 16px', cursor: 'pointer', fontSize: '13px', fontWeight: 700, display: 'flex', alignItems: 'center', gap: '8px' }}>
                            <i className="bi bi-box-arrow-right"></i> Logout
                        </Link>
                    </div>
                </header>

                <main style={{ flex: 1, padding: '32px', background: '#f8fafc' }}>
                    {children}
                </main>
            </div>
        </div>
    );
}
