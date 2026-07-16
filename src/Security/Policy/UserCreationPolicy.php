<?php

namespace App\Security\Policy;

use Symfony\Component\Security\Core\User\UserInterface;

class UserCreationPolicy
{
    /**
     * Nettoie et valide les rôles selon le contexte
     */
    public function resolveRoles(array $roles, bool $isAdminContext): array
    {
        if (!$isAdminContext) {
            return ['ROLE_STUDENT'];
        }

        if (empty($roles)) {
            return ['ROLE_STUDENT'];
        }

        return $roles;
    }

    /**
     * Vérifie si un rôle peut être assigné en dehors du contexte admin
     */
    public function canAssignRoles(array $roles, bool $isAdminContext): bool
    {
        if ($isAdminContext) {
            return true;
        }

        // en public, seul ROLE_STUDENT est autorisé
        return empty(array_diff($roles, ['ROLE_STUDENT']));
    }

    /**
     * Rôles par défaut
     */
    public function getDefaultRoles(): array
    {
        return ['ROLE_STUDENT'];
    }

    /**
     * Auto login après création utilisateur
     */
    public function shouldAutoLogin(bool $isPublicRegistration): bool
    {
        return $isPublicRegistration;
    }

    /**
     * Détermine si on est dans un contexte admin
     */
    public function isAdminContext(array $currentUserRoles): bool
    {
        return in_array('ROLE_ADMIN', $currentUserRoles, true);
    }

    /**
     * Sécurise totalement la création utilisateur (règle centrale)
     */
    public function sanitizeRoles(array $roles, ?UserInterface $actor): array
    {
        $isAdmin = in_array('ROLE_ADMIN', $actor?->getRoles() ?? [], true);

        if (!$isAdmin) {
            return ['ROLE_STUDENT'];
        }

        return $roles ?: ['ROLE_STUDENT'];
    }
}