import { useState, useEffect } from 'react';
import { Link, usePage } from '@inertiajs/react';

const NAV_ITEMS = [
    { label: 'Dashboard',   icon: 'bi-house-door',     href: 'dashboard' },
    { label: 'Courses',      icon: 'bi-play-circle',    href: 'enrollments.index' },
    { label: 'Browse',       icon: 'bi-grid',           href: 'courses.index' },
    { label: 'Live Classes', icon: 'bi-camera-video',   href: 'live-classes.index' },
    { label: 'Resources',    icon: 'bi-file-earmark',   href: 'materials.index' },
    { label: 'Billing',      icon: 'bi-credit-card',    href: 'fees.index' },
    { label: 'Profile',      icon: 'bi-person',         href: 'profile.edit' },
    { label: 'Register',     icon: 'bi-plus-circle',    href: 'admissions.create' },
];

const TRAINER_NAV = [
    { label: 'Dashboard',    icon: 'bi-speedometer2',   href: 'trainer.dashboard' },
    { label: 'My Courses',   icon: 'bi-camera-video',   href: 'trainer.dashboard' }, // Placeholder for trainer routes
    { label: 'Profile',      icon: 'bi-person',         href: 'profile.edit' },
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
        <div style={{ display: 'flex', minHeight: '100vh', background: '#f9fafb', fontFamily: "'Inter', sans-serif" }}>

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
                .nav-link:hover { background: #f1f5f9 !important; color: #1e293b !important; }
            `}</style>

            {/* ── SIDEBAR ── */}
            <aside style={{
                width: sidebarOpen ? '260px' : '72px',
                minHeight: '100vh',
                background: '#ffffff',
                borderRight: '1px solid #f1f5f9',
                display: 'flex',
                flexDirection: 'column',
                position: 'fixed',
                top: 0, left: 0,
                zIndex: 1040,
                transition: 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)',
                overflowX: 'hidden',
            }}>
                <div style={{ height: '72px', display: 'flex', alignItems: 'center', padding: '0 24px', gap: '12px', flexShrink: 0 }}>
                    <div style={{ width: '36px', height: '36px', borderRadius: '8px', background: '#e3000f', display: 'flex', alignItems: 'center', justifyContent: 'center', flexShrink: 0 }}>
                        <i className="bi bi-building-fill" style={{ color: '#fff', fontSize: '18px' }}></i>
                    </div>
                    {sidebarOpen && <div style={{ fontWeight: 800, fontSize: '20px', color: '#1e293b', letterSpacing: '-0.5px' }}>The Ace India</div>}
                </div>

                {/* Profile Section (Top) */}
                {sidebarOpen && user && (
                    <div style={{ padding: '24px 20px', borderBottom: '1px solid #f1f5f9' }}>
                        <div style={{ display: 'flex', alignItems: 'center', gap: '14px', cursor: 'pointer' }}>
                            <div style={{ width: '44px', height: '44px', borderRadius: '50%', background: '#e2e8f0', display: 'flex', alignItems: 'center', justifyContent: 'center', overflow: 'hidden' }}>
                                <img src={`https://ui-avatars.com/api/?name=${user.name}&background=random`} alt={user.name} style={{ width: '100%', height: '100%' }} />
                            </div>
                            <div style={{ flex: 1, overflow: 'hidden' }}>
                                <div style={{ fontSize: '14px', fontWeight: 700, color: '#1e293b', whiteSpace: 'nowrap', overflow: 'hidden', textOverflow: 'ellipsis' }}>{user.name}</div>
                                <div style={{ fontSize: '12px', color: '#64748b', overflow: 'hidden', textOverflow: 'ellipsis' }}>{user.email}</div>
                            </div>
                            <i className="bi bi-chevron-down" style={{ fontSize: '12px', color: '#94a3b8' }}></i>
                        </div>
                    </div>
                )}

                <nav style={{ flex: 1, padding: '16px 12px', overflowY: 'auto' }}>
                    {(user?.is_trainer ? TRAINER_NAV : NAV_ITEMS).map(item => {
                        const href = `/${item.href.replace(/\./g, '/')}`;
                        const active = window.location.pathname === href || (item.href === 'dashboard' && window.location.pathname === '/dashboard') || (item.href === 'trainer.dashboard' && window.location.pathname === '/trainer');
                        return (
                            <Link key={item.label} href={route(item.href)} className="nav-link" style={{
                                display: 'flex', alignItems: 'center', gap: '14px', padding: '10px 14px', borderRadius: '8px', marginBottom: '4px',
                                color: active ? '#e3000f' : '#64748b', background: active ? '#fff1f2' : 'transparent',
                                textDecoration: 'none', fontWeight: active ? 700 : 500, fontSize: '14px', transition: 'all 0.2s',
                            }}>
                                <i className={`bi ${item.icon}`} style={{ fontSize: '18px', color: active ? '#e3000f' : 'inherit', opacity: active ? 1 : 0.7 }}></i>
                                {sidebarOpen && <span>{item.label}</span>}
                            </Link>
                        );
                    })}
                </nav>

                {/* Sidebar Footer */}
                {sidebarOpen && (
                    <div style={{ padding: '16px 12px', borderTop: '1px solid #f1f5f9' }}>
                        <Link href={route('profile.edit')} style={{ display: 'flex', alignItems: 'center', gap: '14px', padding: '10px 14px', color: '#64748b', textDecoration: 'none', fontSize: '14px' }}>
                            <i className="bi bi-person-circle"></i>
                            <span>Manage profile</span>
                        </Link>
                        <Link href={route('logout')} method="post" as="button" style={{ width: '100%', border: 'none', background: 'none', display: 'flex', alignItems: 'center', gap: '14px', padding: '10px 14px', color: '#64748b', fontSize: '14px', cursor: 'pointer' }}>
                            <i className="bi bi-box-arrow-right"></i>
                            <span>Logout</span>
                        </Link>
                    </div>
                )}
            </aside>

            {/* ── MAIN CONTENT ── */}
            <div style={{ marginLeft: sidebarOpen ? '260px' : '72px', flex: 1, display: 'flex', flexDirection: 'column', transition: 'margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1)', minHeight: '100vh' }}>
                <header style={{
                    background: '#ffffff', height: '72px', display: 'flex', alignItems: 'center',
                    justifyContent: 'space-between', padding: '0 32px', position: 'sticky', top: 0, zIndex: 1030, borderBottom: '1px solid #f1f5f9',
                }}>
                    <div style={{ display: 'flex', alignItems: 'center', gap: '20px', flex: 1 }}>
                        <button onClick={() => setSidebarOpen(!sidebarOpen)} style={{ background: 'none', border: 'none', color: '#64748b', fontSize: '24px', cursor: 'pointer', display: 'flex' }}><i className="bi bi-list"></i></button>
                        
                        {/* Search Bar (Sample style) */}
                        <div style={{ position: 'relative', width: '300px' }}>
                            <i className="bi bi-search" style={{ position: 'absolute', left: '12px', top: '50%', transform: 'translateY(-50%)', color: '#94a3b8', fontSize: '14px' }}></i>
                            <input 
                                type="text" 
                                placeholder="Quick search for anything.." 
                                style={{ width: '100%', padding: '8px 12px 8px 36px', borderRadius: '8px', border: 'none', background: 'none', fontSize: '14px', outline: 'none' }}
                            />
                        </div>
                    </div>

                    <div style={{ display: 'flex', alignItems: 'center', gap: '20px' }}>
                        <i className="bi bi-envelope" style={{ fontSize: '20px', color: '#64748b', cursor: 'pointer' }}></i>
                        <div style={{ position: 'relative' }}>
                            <i className="bi bi-bell" style={{ fontSize: '20px', color: '#64748b', cursor: 'pointer' }}></i>
                            <span style={{ position: 'absolute', top: '-4px', right: '-4px', background: '#e3000f', color: '#fff', fontSize: '10px', fontWeight: 700, borderRadius: '50%', width: '16px', height: '16px', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>2</span>
                        </div>
                        <div style={{ width: '32px', height: '32px', borderRadius: '50%', background: '#e2e8f0', display: 'flex', alignItems: 'center', justifyContent: 'center', overflow: 'hidden', cursor: 'pointer' }}>
                            <img src={`https://ui-avatars.com/api/?name=${user?.name}&background=random`} alt="User" style={{ width: '100%', height: '100%' }} />
                        </div>
                    </div>
                </header>

                <main style={{ flex: 1, padding: '32px' }}>
                    {children}
                </main>
            </div>
        </div>
    );
}
